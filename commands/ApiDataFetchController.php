<?php

namespace app\commands;

use Yii;
use GuzzleHttp\Client;
use app\services\FetchData;
use app\component\Constants;
use app\models\ProductsApiList;
use app\commands\ConsoleController;
use app\models\ProductCompanyMapping;
use DateTime;
use Exception;
use yii\helpers\ArrayHelper;

class ApiDataFetchController extends ConsoleController
{
    use FetchData;
    const DEFAULT_PAGE_SIZE = 100;

    public function actionRun()
    {
        $model = ProductCompanyMapping::find()->active()->all();
        foreach ($model as $product) {
            $apiList = $this->getApiConfigs($product->product_id);
            if (!empty($apiList)) {
                $tokenKey = "token_{$product->company_id}_{$product->product_id}";
                $cacheToken = Yii::$app->cache->get($tokenKey);
                $loginDetails = !empty($cacheToken) ? $cacheToken : $this->getAuthorizationToken($product);
                if ($loginDetails["status"] == Constants::STATUS_INACTIVE) {
                    Yii::$app->cache->delete('token_' . $product->id);
                    $loginDetails = $this->getAuthorizationToken($product);
                }
                if ($loginDetails['status'] == Constants::STATUS_ACTIVE) {
                    Yii::$app->cache->set($tokenKey, $loginDetails, 300);
                    $token = $loginDetails['data']['token'];

                    $extraData = array_merge(['<token>' => $token], $this->getDynamicData($product->headers));
                    $globalHeaders = [];
                    if (!empty($product->products->auth_headers)) {
                        $globalHeaders = ArrayHelper::merge($globalHeaders, $this->mergeKeyValue($product->products->auth_headers, '', $extraData));
                    }

                    if ($product->headers) {
                        $globalHeaders = ArrayHelper::merge($globalHeaders, $this->mergeKeyValue($product->headers, '', $extraData));
                    }
                    $config = [
                        'headers' => $globalHeaders,
                        "base_uri" => rtrim($product->products->base_url, '/'),
                        "company_id" => $product->company_id,
                        "extraData" => $extraData,
                    ];
                    $this->fetchAndSaveData($apiList, $config);
                }
            }
        }
    }
    private function isJson($string)
    {
        if (!is_string($string))
            return false;

        json_decode($string);
        return (json_last_error() === JSON_ERROR_NONE);
    }


    private function getDynamicData($data)
    {
        $resp = [];
        foreach ($data as $ds) {
            if (str_contains($ds["key"], "<")) {
                $resp[$ds["key"]] = $ds["val"];
            }
        }
        return $resp;
    }

    private function mergeKeyValue($dataSets, $type = "", $extraData = [])
    {
        if (empty($dataSets)) {
            return [];
        }
        $resp = [];
        switch ($type) {
            case "url":
                $r = [];
                foreach ($dataSets as $ds) {
                    if (str_contains($ds["key"], "<")) {
                        continue;
                    }
                    if (!empty($ds['key']) && !empty($ds['val'])) {
                        $val = $ds['val'];
                        $val = $this->formalizeData($val, $extraData);
                        if ($this->isJson($val)) {
                            $val = json_decode($val, true);
                        }
                        $r[] = $ds["key"] . "=" . $val;
                    }
                    $resp = implode("&", $r);
                }
                break;
            default:
                foreach ($dataSets as $ds) {
                    if (str_contains($ds["key"], "<")) {
                        continue;
                    }
                    if (!empty($ds['key']) && !empty($ds['val'])) {
                        $val = $ds['val'];
                        $val = $this->formalizeData($val, $extraData);
                        if ($this->isJson($val)) {
                            $val = json_decode($val, true);
                        }

                        $resp[$ds["key"]] = $val;
                    }
                }
                break;
        }
        return $resp;
    }

    private function extractAngleBracketContent(string $input): array
    {
        preg_match_all('/<([^<>]+)>/', $input, $matches);
        return $matches[1] ?? [];
    }


    private function formalizeData($data, $extra = [])
    {
        $resp = $data;

        $contents = $this->extractAngleBracketContent($data);
        foreach ($contents as $content) {
            if (!empty($extra["<$content>"])) {
                $resp = str_replace("<$content>", $extra["<$content>"], $resp);
            }
        }
        
        if (str_contains($resp, '<currenttimestamp>')) {
            $date = DateTime::createFromFormat('Y-m-d H:i:s.u', date('Y-m-d H:i:s.u'));
            $milliseconds = (int) ($date->format('Uu') / 1000);
            $resp = str_replace('<currenttimestamp>', $milliseconds, $resp);
        }

        if (str_contains($resp, '<last7daytimestamp>')) {
            $date = DateTime::createFromFormat('Y-m-d H:i:s.u', date('Y-m-d H:i:s.u', strtotime("-7 days")));
            $milliseconds = (int) ($date->format('Uu') / 1000);
            $resp = str_replace('<last7daytimestamp>', $milliseconds, $resp);
        }

        return $resp;
    }

    private function getAuthorizationToken($product)
    {
        switch ($product->products->authentication_type) {
            case Constants::AUTH_TYPE_LOGIN:
                $headers = empty($product->products['login_headers']) ? [] : $product->products['login_headers'];
                $headers = $this->mergeKeyValue($headers);
                $body = $product->credentials;
                $body['kill_existing_session'] = true;
                $body['token'] = "";
                $url = rtrim($product->products->base_url, '/') . '/' . ltrim($product->products->login_endpoint, '/');
                $res = $this->getData($url, $method = "POST", $headers, $body);
                print_r($res);
                if (!empty($res)) {
                    $token = null;
                    if (!empty($res["body"]["response"][1]["jwttoken"])) {
                        $token = $res["body"]["response"][1]["jwttoken"];
                        return [
                            'status' => Constants::STATUS_ACTIVE,
                            'data' => [
                                'token' => $token
                            ]
                        ];
                    } else {
                        return [
                            'status' => Constants::STATUS_INACTIVE,
                            'data' => null
                        ];
                    }
                }
                break;
            case Constants::AUTH_TYPE_TOKEN:
                return [
                    'status' => Constants::STATUS_ACTIVE,
                    'data' => [
                        'token' => $product->credentials['token']
                    ]
                ];
            default:
                return [
                    'status' => Constants::STATUS_INACTIVE,
                    'data' => []
                ];
        }
    }

    private function getApiConfigs($product_id)
    {
        return ProductsApiList::find()->active()->andWhere(["product_id" => $product_id])->all();
    }

    private function fetchAndSaveData($apiList, $config)
    {
        foreach ($apiList as $api) {
            try {
                if ($api->is_pagination) {
                    $this->fetchPaginatedApi($api, $config);
                } else {
                    $this->fetchApi($api, $config);
                }
            } catch (Exception $e) {
                print_r($e->getMessage());
            }

        }
    }

    private function fetchApi($api, $config = [])
    {

        $url = rtrim($config['base_uri'], '/') . '/' . ltrim($api['api_endpoint'], '/');
        if (!empty($api['api_params'])) {
            $url .= "?" . $this->mergeKeyValue($api["api_params"], "url",$config['extraData']);
        }
        $header = array_merge(
            $config['headers'],
            !empty($api['api_headers']) ? $this->mergeKeyValue($api['api_headers'], '', $config['extraData']) : []
        );

        $params = !empty($api['api_body']) ? $this->mergeKeyValue($api['api_body'], "", $config["extraData"]) : [];
        $res = $this->getData($url, $api['api_method'], $header, $params);

        print_r([
            "header" => $header,
            "url" => $url,
            "res" => $res,
            "params" => $params,
            "method" => $api['api_method']
        ]);
        $collectionName = strtolower(preg_replace('/[^a-z0-9_]/i', '_', $api['api_name'] . "_" . $api['id']));
        if ($res) {
            if (!empty($res["body"]["results"])) {
                $this->saveToMongoCollection($collectionName, $res["body"]["results"], $config);
            }
        }
    }

    private function fetchPaginatedApi($api, $config = [])
    {

        $collectionName = strtolower(preg_replace('/[^a-z0-9_]/i', '_', $api['api_name'] . "_" . $api['id']));

        $url = rtrim($config['base_uri'], '/') . '/' . ltrim($api['api_endpoint'], '/');
        if (!empty($api['api_params'])) {
            $url .= "?" . $this->mergeKeyValue($api["api_params"], "url",$config['extraData']);
        }

        $header = array_merge(
            $config['headers'],
            !empty($api['api_headers']) ? $this->mergeKeyValue($api['api_headers'], '', $config['extraData']) : []
        );
        
        $skip = 0;
        $remaingCount = 0;
        do {
            if ($remaingCount <= 0 && $skip != 0) {
                break;
            }
            $remaingCount = $this->fetchAndSavePagination($url, $header, $api['api_method'], $collectionName, $skip, $remaingCount, $config, $api['api_body']);
            $skip++;
            echo "remaingCount => {$remaingCount} and skipCount => {$skip}" . PHP_EOL;
        } while ($remaingCount > 0);

    }

    private function fetchAndSavePagination($url, $headers, $method, $collectionName, $skip, $remaingCount, $config = [], $params = [])
    {
        $remaingCount = $remaingCount == 0 ? $skip * self::DEFAULT_PAGE_SIZE : $remaingCount;
        $endpoint = $url;
        $endpoint .= (str_contains($url, "?") ? "&" : "?") . "skip=" . $skip;

        $data = $this->getData($endpoint, $method, $headers);
        print_r([
            "header" => $headers,
            "url" => $endpoint,
            "res" => $data,
            "method" => $method
        ]);

        if (!isset($data["body"]["totalCount"]) && $skip == 0) {
            $data["body"]["totalCount"] = 1000;// count($data["body"]);
        }
        if ($remaingCount == 0 && $data["body"]["totalCount"] > 0 && $skip == 0) {
            $remaingCount = $data["body"]["totalCount"];
            $isDelete = true;
        }
        $records = !empty($data["body"]["results"]) ? $data["body"]["results"] :
            (!empty($data['body']['resources']) ? $data['body']['resources'] :
                (!empty($data['body']) ? $data['body'] : []));
        if (!empty($records)) {
            unset($records['totalCount']);
            $savedCount = $this->saveToMongoCollection($collectionName, $records, $config);
            $remaingCount = $remaingCount - $savedCount;
        } else {
            $remaingCount = 0;
        }
        return $remaingCount;
    }

    private function saveToMongoCollection($collectionName, $data, $config)
    {
        $i = 0;
        $collection = Yii::$app->mongodb->getCollection($collectionName);
        $collection->remove(["company_id" => $config['company_id']]);
        foreach ($data as $d) {
            $fd = array_merge(
                $d,
                [
                    'fetched_at' => date("YmdHi"),
                    "company_id" => $config['company_id'],
                ]
            );
            $collection->insert($fd);
            $i++;
        }
        return $i;
    }

    private function logError($apiId, $message)
    {
        Yii::error("API ID: $apiId failed. Error: $message", 'apiFetch');
    }

}