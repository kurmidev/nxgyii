<?php

namespace app\component;

use app\models\ProductCompanyMapping;
use app\models\User;
use app\services\FetchData;
use Yii;
use yii\data\ArrayDataProvider;
use yii\mongodb\Query;

class CustomData
{
    use FetchData;

    private function getDataFromJumpCloud($endpoints, $method, $params)
    {
        $user = User::currentUser();
        if ($user->company_id > 0) {
            $model = ProductCompanyMapping::findOne(
                [
                    'company_id' => $user->company_id,
                    "product_id" => Yii::$app->params['services']["JUMPCLOUD"]
                ]
            );
            $token = $model->credentials['token'];
            $url = rtrim($model->products->base_url, '/') . $endpoints;
            $headers = [
                'x-api-key' => $token,
                'Content-Type' => 'application/json',
            ];
            $data = $this->getData($url, $method, $headers, $params);
            return !empty($data["body"]["alerts"]) ? $data["body"]["alerts"] :
                (!empty($data['body']['buckets']) ? $data['body']['buckets'] : []);
        }
        return [];
    }
    public function getAlertsData()
    {
        //ALERT_STATUS_OPEN
        $counts = [
            "ALERT_STATUS_OPEN" => 0,
            "ALERT_STATUS_ACKNOWLEDGED" => 0,
            "ALERT_STATUS_RESOLVED" => 0,
            "ALERT_STATUS_AUTO_RESOLVED" => 0
        ];

        $data = $this->getDataFromJumpCloud("/v2/alerts", "GET", []);
        $unsetColumns = ['_id', 'id', "company_id", "fetched_at"];
        $response = $columns = $fields = [];
        foreach ($data as $doc) {
            $res = [];
            if (isset($counts[$doc['status']])) {
                $counts[$doc['status']]++;
            }
            foreach ($doc as $k => $val) {
                if (empty($response)) {
                    if (!is_array($val) && !in_array($k, $unsetColumns)) {
                        if (empty($diplayColumns)) {
                            $columns[] = "$k:text:" . Utils::convertToHeaderCase($k);
                            $fields[] = $k;
                        }
                    }
                }
                if (!is_array($val) && !in_array($k, $unsetColumns)) {
                    if (!empty($diplayColumns) && in_array($k, $diplayColumns)) {
                        $res[$k] = $val;
                    } else if (empty($diplayColumns)) {
                        $res[$k] = $val;
                    }
                }
            }
            $response[] = $res;
        }
        if (empty($columns)) {
            $columns = ["Srno"];
        }
        return [$columns, $fields, $response, $counts];
    }

    public function getSearchModel($fields)
    {
        $searchModel = new \yii\base\DynamicModel($fields);
        foreach ($fields as $field) {
            $searchModel->addRule($field, 'safe');
        }
        return $searchModel;
    }

    /**
     * Filters response data based on search model attributes
     *
     * @param \yii\base\DynamicModel $searchModel Dynamic search model containing filter attributes
     * @param array $response Original data array to be filtered
     * @param array $filters Input filters to apply to the search model
     * @return array Filtered response data matching search criteria
     */
    public function getFilterData($searchModel, $response, $filters)
    {
        if ($searchModel->load($filters, '')) {
            $data = array_filter($response, function ($item) use ($searchModel) {
                foreach ($searchModel->attributes as $field => $value) {
                    if ($value === '' || !isset($item[$field]))
                        continue;
                    if (stripos((string) $item[$field], $value) === false) {
                        return false;
                    }
                }
                return true;
            });
            $response = $data;
        }
        return $response;
    }

    public function getInsightsGarphData()
    {
        $response = [];
        $params = [
            "service" => ["all"],
            "start_time" => date("Y-m-d\TH:i:s.000\Z"),
            "timezone" => "+0530",
            "interval_unit" => "m",
            "interval_value" => "4",
            "q" => ""
        ];
        $data = $this->getDataFromJumpCloud("/v2/directoryinsights/events/interval", "POST", $params);
        if (!empty($data)) {
            foreach ($data as $d) {
                $response[] = [
                    "category" => date("H:i", $d['key']),
                    "value" => $d['doc_count']
                ];
            }
        }
        return $response;
    }

    public function getInsightData()
    {
        $params = [
            "service" => ["all"],
            "start_time" => date("Y-m-d\TH:i:s.000\Z", strtotime("-7 days")),
        ];
        $user = User::currentUser();
        $unsetColumns = ['_id', 'id', "company_id", "fetched_at"];
        if ($user->company_id > 0) {
            $model = ProductCompanyMapping::findOne(
                [
                    'company_id' => $user->company_id,
                    "product_id" => Yii::$app->params['services']["JUMPCLOUD"]
                ]
            );
            $token = $model->credentials['token'];
            $url = "https://api.jumpcloud.com/insights/directory/v1/events";
            $headers = [
                'x-api-key' => $token,
                'Content-Type' => 'application/json',
            ];
            $data = $this->getData($url, "POST", $headers, $params);
            $response = $columns = $fields = [];
            foreach ($data["body"] as $doc) {
                $res = [];
                foreach ($doc as $k => $val) {
                    if (empty($response)) {
                        if (!is_array($val) && !in_array($k, $unsetColumns)) {
                            $columns[] = str_replace("@","",$k).":text:" . Utils::convertToHeaderCase($k);
                            $fields[] = $k;
                        }
                    }
                    if (!is_array($val) && !in_array($k, $unsetColumns)) {
                        $res[str_replace("@","",$k)] = $val;
                    }
                }
                $response[] = $res;
            }
            if (empty($columns)) {
                $columns = ["Srno"];
            }
            return [$columns, $fields, $response];
        }
        return [];
    }
}