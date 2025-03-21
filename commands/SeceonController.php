<?php

namespace app\commands;

use Yii;
use app\models\ProductMaster;
use app\models\seceon\AlertAnalysisModel;
use app\models\seceon\AlertDataModel;
use app\models\seceon\DashboardModel;
use app\models\seceon\NewAlertAnalysisModel;
use app\models\seceon\SeceonAlertData;
use app\models\seceon\SeceonEventDataModel;
use app\models\seceon\SeceonSystemAlertModel;
use app\models\seceon\SeceonSystemAlertSearch;
use app\models\seceon\SeceonTenantModel;
use app\models\seceon\ThreatDataModel;
use app\services\FetchData;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

class SeceonController extends ConsoleController
{

    use FetchData;
    private $token;
    const SECEON_TOKEN = "seceon";
    const MASTER_TENANT_ID = "OTMMasterTenant";
    public $apiObject;

    private $tenant_mapping = [
        "DXN7889" => "apeMTokytLjmE2OC40MC4xMTEape",
        "PFO2702" => "apeMToQ4tLjmExMy4zNS4xMDkape"
    ];
    public static $baseUrl = "https://otmin.seceon.ai";
    public function __construct($id, $module, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->cron_name = "JumpCloud Sync Users";
        $this->apiObject = ProductMaster::getProductObjects()['SECEON'];
    }

    private function login()
    {
        $seceon = Yii::$app->params['seceon'];
        $req = [
            "username" => $seceon['username'],
            "password" => $seceon['password'],
        ];

        $res = $this->getData($seceon['loginUrl'], $method = "POST", $headers = ['Content-Type' => 'application/json',], $req);
        if (!empty($res["body"]["response"][1]["jwttoken"])) {
            return $res["body"]["response"][1]["jwttoken"];
        } else {
            print_r($res);
        }
        return false;
    }

    private function getTokenValues()
    {
        $checkToken = Yii::$app->cache->get(self::SECEON_TOKEN);
        if (empty($checkToken)) {
            $checkToken = $this->login();

            if ($checkToken) {
                Yii::$app->cache->set(self::SECEON_TOKEN, $checkToken, 3600);
            } else {
                return false;
            }
        }
        echo "Token Value fetched successfully." . PHP_EOL;
        $this->token = $checkToken;
        return true;
    }

    public function actionSyncData()
    {

        if ($this->getTokenValues()) {
            $this->fetchDashboardData();
            $this->getAlerts();
            $this->alertAnalysisData();
            $this->newAlertAnalysis();
            $this->getTenantDetails();
            $this->getEventsData();
            $this->getThreatData();
            $this->getSystemAlerts();
        }
    }

    private function fetchDashboardData()
    {
        $url = "/mssp/v1/read/mssp/mssp-dashboard/data?from_time=7d&to_time=now&time_range_type=commonly%20used&mid=edfdaa6c-0f40-433a-9638-b32490aa22c8";
        $endpoint = $this->apiObject::$baseUrl . $url;
        $headers = [
            //'Content-Type' => 'application/json',
            "Authorization" => "Bearer " . $this->token,
            "tenant_id" => self::MASTER_TENANT_ID
        ];

        $data = $this->getData($endpoint, "GET", $headers);
        if (!empty($data["body"]["results"])) {
            DashboardModel::deleteAll([]);
            foreach ($data["body"]["results"] as $d) {
                $model = new DashboardModel();
                $model->load($d, '');

                if ($model->validate() && $model->save()) {
                    echo "Dahboard data saved successfully" . PHP_EOL;
                } else {
                    print_r($model->errors);
                }
            }
        }
    }

    private function getAlerts()
    {
        $url = "/mssp/v1/read/mssp/common/data?mid=edfdaa6c-0f40-433a-9638-b32490aa22c8";
        $endpoint = $this->apiObject::$baseUrl . $url;
        $headers = [
            'Content-Type' => 'application/json',
            "Authorization" => "Bearer " . $this->token,
            "tenant_id" => self::MASTER_TENANT_ID
        ];
        $data = $this->getData($endpoint, "GET", $headers);

        if (!empty($data["body"]["results"])) {
            AlertDataModel::deleteAll([]);
            foreach ($data["body"]["results"] as $d) {
                $model = new AlertDataModel();
                $model->load($d, '');
                if ($model->validate() && $model->save()) {
                    echo "Dahboard data saved successfully" . PHP_EOL;
                } else {
                    print_r($model->errors);
                }
            }
        }
    }

    private function alertAnalysisData()
    {

        $model = DashboardModel::find()->indexBy("tenant_id")->asArray()->all();
        $tenantids = !empty($model) ? array_keys($model) : array();
        if (!empty($tenantids)) {
            AlertAnalysisModel::deleteAll([]);
        }
        foreach ($tenantids as $tenantid) {
            $url = "/{$this->tenant_mapping[$tenantid]}/uiserver/v1/read/tenant/new-alert-analysis/fetch";
            $endpoint = $this->apiObject::$baseUrl . $url;

            $headers = [
                'Content-Type' => 'application/json',
                "Authorization" => "Bearer " . $this->token,
                "tenant_id" => $tenantid,
            ];
            $params = [
                "tenant_id" => $tenantid,
                "from" => "7d",
                "to" => "now",
                "time_range_type" => "commonly used",
                "severity" => "",
                "status" => "",
                "assigned" => "",
                "uda" => ""
            ];
            $data = $this->getData($endpoint, "POST", $headers, $params);

            if (!empty($data["body"]["results"])) {

                foreach ($data["body"]["results"] as $d) {
                    $model = new NewAlertAnalysisModel();
                    $model->load($d, '');
                    if ($model->validate() && $model->save()) {
                        echo "Alert analysis data saved successfully" . PHP_EOL;
                    } else {
                        print_r($model->errors);
                    }
                }
            }
        }
    }

    private function newAlertAnalysis()
    {
        $model = DashboardModel::find()->indexBy("tenant_id")->asArray()->all();
        $tenantids = !empty($model) ? array_keys($model) : array();
        if (!empty($tenantids)) {
            NewAlertAnalysisModel::deleteAll([]);
        }

        $severity = ["Closed", "Open", "Remediated"];

        foreach ($tenantids as $tenantid) {
            //$url = "/apeMToQ4tLjmExMy4zNS4xMDkape;
            $url = $this->tenant_mapping[$tenantid];
            $endpoint = $this->apiObject::$baseUrl . "/" . $url . "/uiserver/v1/read/tenant/new-alert-analysis/fetch";
            $headers = [
                'Content-Type' => 'application/json',
                "Authorization" => "Bearer " . $this->token,
                "tenant_id" => $tenantid,
            ];
            foreach ($severity as $key) {
                $params = [
                    "from" => "7d",
                    "to" => "now",
                    "status" => $key,
                    "severity" => "",
                    "tenant_id" => $tenantid,
                    "assigned" => "",
                    "uda" => "",
                    "entity_type" => "",
                    "time_range_type" => "commonly used"
                ];
                print_r($params);
                $data = $this->getData($endpoint, "POST", $headers, $params);

                if (!empty($data["body"]["results"])) {

                    foreach ($data["body"]["results"] as $d) {
                        print_r($d);
                        $model = new NewAlertAnalysisModel();
                        $model->load($d, '');
                        if ($model->validate() && $model->save()) {
                            echo "New Alert analysis data saved successfully" . PHP_EOL;
                        } else {
                            print_r($model->errors);
                        }
                    }
                }
            }
        }
    }

    private function getTenantDetails()
    {
        $url = "/mssp/v1/read/mssp/mssp-dashboard/details?mid=edfdaa6c-0f40-433a-9638-b32490aa22c8";
        $endpoint = $this->apiObject::$baseUrl . $url;
        $headers = [
            'Content-Type' => 'application/json',
            "Authorization" => "Bearer " . $this->token,
            "tenant_id" => self::MASTER_TENANT_ID
        ];
        $data = $this->getData($endpoint, "GET", $headers);
        if (!empty($data["body"]["results"])) {
            SeceonTenantModel::deleteAll([]);
            foreach ($data["body"]["results"] as $d) {
                $model = new SeceonTenantModel();
                $model->load($d, '');
                if ($model->validate() && $model->save()) {
                    echo "Tenant data saved successfully" . PHP_EOL;
                } else {
                    print_r($model->errors);
                }
            }
        }
    }

    private function getEventsData()
    {
        $tenants = SeceonTenantModel::find()->indexBy("tenant_id")->asArray()->all();
        SeceonEventDataModel::deleteAll([]);
        foreach ($tenants as $tenant_id => $tenants) {
            $url = "/{$this->tenant_mapping[$tenant_id]}/uiserver/v1/read/tenant/log-flow-collection/get/logsFlowsCollectionByDevices?tenant_id=" . $tenant_id . "&from=7d&to=now&time_range_type=commonly%20used";
            $endpoint = $this->apiObject::$baseUrl . $url;
            $headers = [
                "Authorization" => "Bearer " . $this->token,
                "tenant_id" => $tenant_id
            ];
            $data = $this->getData($endpoint, "GET", $headers);

            if (!empty($data["body"]["results"][0])) {
                foreach ($data["body"]["results"][0] as $type => $d) {
                    foreach ($d as $log) {
                        $model = new SeceonEventDataModel();
                        $model->load($log, '');
                        $model->log_type = $type;
                        $model->tenant_id = $tenant_id;
                        if ($model->validate() && $model->save()) {
                            echo "Events data saved successfully" . PHP_EOL;
                        } else {
                            print_r($model->errors);
                        }

                    }
                }
            }
        }

    }

    public function getThreatData()
    {
        $tenants = SeceonTenantModel::find()->indexBy("tenant_id")->asArray()->all();
        SeceonEventDataModel::deleteAll([]);
        foreach ($tenants as $tenant_id => $tenants) {
            $url = "/{$this->tenant_mapping[$tenant_id]}/uiserver/v1/read/tenant/deep-tracker/report/threatindicator/selectThreatIndicators";
            $endpoint = $this->apiObject::$baseUrl . $url;
            $headers = [
                'Content-Type' => 'application/json',
                "Authorization" => "Bearer " . $this->token,
                "tenant_id" => $tenant_id
            ];
            $params = [
                "tenant_id" => $tenant_id,
                "timezone" => "Asia/Kolkata",
                "lucene" => "",
                "displayRule" => [
                    "condition" => "and",
                    "rules" => [
                        ["label" => "Date", "field" => "timestamp", "type" => "date", "operator" => "greaterthanorequal", "value" => 1741927763616],
                        ["label" => "Date", "field" => "timestamp", "type" => "date", "operator" => "lessthanorequal", "value" => 1742532563616]
                    ]
                ],
                "type" => "type"
            ];
            $data = $this->getData($endpoint, "POST", $headers, $params);
            if (!empty($data["body"]["results"])) {
                ThreatDataModel::deleteAll([]);
                foreach ($data["body"]["results"] as $type => $d) {
                    $model = new ThreatDataModel();
                    $model->load($d, '');
                    $model->tenant_id = $tenant_id;
                    if ($model->validate() && $model->save()) {
                        echo "Threats data saved successfully" . PHP_EOL;
                    } else {
                        print_r($model->errors);
                    }
                }
            }
        }
    }

    public function getSystemAlerts()
    {
        $tenants = SeceonTenantModel::find()->indexBy("tenant_id")->asArray()->all();
        $startTimeStamp = strtotime("-7 days");
        $todays = strtotime("now");
        $statusArray = ["OPEN", "CLOSED"];
        SeceonSystemAlertModel::deleteAll([]);
        foreach ($tenants as $tenant_id => $tenants) {
            foreach ($statusArray as $status) {
                $url = $this->tenant_mapping[$tenant_id];
                $endpoint = $this->apiObject::$baseUrl . "/" . $url . "/uiserver/v1/read/tenant/system-alerts/system/showSystemAlerts?tenant_id={$tenant_id}&from={$startTimeStamp}&to={$todays}&time_range_type=absolute&status={$status}";
                $headers = [
                    'Content-Type' => 'application/json',
                    "Authorization" => "Bearer " . $this->token,
                    "tenant_id" => $tenant_id
                ];

                $data = $this->getData($endpoint, "GET", $headers);
                if (!empty($data["body"]["results"])) {
                    foreach ($data["body"]["results"] as $type => $d) {
                        $model = new SeceonSystemAlertModel();
                        $model->load($d, '');
                        $model->tenant_id = $tenant_id;
                        if ($model->validate() && $model->save()) {
                            echo "Threats data saved successfully" . PHP_EOL;
                        } else {
                            print_r($model->errors);
                        }
                    }
                }
            }

        }
    }

}