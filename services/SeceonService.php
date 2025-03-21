<?php

namespace app\services;

use app\models\seceon\DashboardModel;
use app\models\seceon\NewAlertAnalysisSearch;
use app\models\seceon\SeceonEventDataModel;
use app\models\seceon\SeceonEventDataSearch;
use app\models\seceon\SeceonSystemAlertSearch;
use app\models\seceon\ThreatDataModel;
use app\models\seceon\ThreatDataModelSearch;
use Yii;

class SeceonService implements IDashborad
{

    public static $baseUrl = "https://otmin.seceon.ai";
    // public static $endPoints = [
    //     "app\models\seceon\DashboardModel"=>"/mssp/v1/read/mssp/mssp-dashboard/data?from_time=".(strtotime('-1 days')*1000)."&to_time=".(strtotime("now"))."&time_range_type=absolute&mid=edfdaa6c-0f40-433a-9638-b32490aa22c8"
    // ];


    public $params;

    public function __construct(array $params = [])
    {
        $this->params = $params;
    }

    public function getDashboardCounts(): array
    {
        $model = DashboardModel::find()->asArray()->all();
        return [
            "data" => $model
        ];
    }

    public function getData($request)
    {
        $title = $columns = $dataProvider = null;

        switch ($request['type']) {
            case "events":
                $searchModel = new SeceonEventDataSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                if (!empty($request['tenant_id'])) {
                    $dataProvider->query->andWhere(['tenant_id' => $request['tenant_id']]);
                }
                $columns = $searchModel->displayColumns();
                $title = "Events Details";
                break;
            case "threats":
                $searchModel = new ThreatDataModelSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                if (!empty($request['tenant_id'])) {
                    $dataProvider->query->andWhere(['tenant_id' => $request['tenant_id']]);
                }
                $columns = $searchModel->displayColumns();
                $title = "Threats Details";
                break;
            case "newalert":
                $searchModel = new NewAlertAnalysisSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                if (!empty($request['tenant_id'])) {
                    $dataProvider->query->andWhere(['tenant_id' => $request['tenant_id'], 'alert_status' => "open"]);
                }
                $columns = $searchModel->displayColumns();
                $title = "Alert Details";
                break;
            case "closed":
                $searchModel = new NewAlertAnalysisSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                if (!empty($request['tenant_id'])) {
                    $dataProvider->query->andWhere(['tenant_id' => $request['tenant_id'], 'alert_status' => "closed"]);
                }
                $columns = $searchModel->displayColumns();
                $title = "Alert Details";
                break;
            case "remediated":
                $searchModel = new NewAlertAnalysisSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                if (!empty($request['tenant_id'])) {
                    $dataProvider->query->andWhere(['tenant_id' => $request['tenant_id'], 'alert_status' => "remediated"]);
                }
                $columns = $searchModel->displayColumns();
                $title = "Alert Details";
                break;
            case "major":
                $searchModel = new NewAlertAnalysisSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                if (!empty($request['tenant_id'])) {
                    $dataProvider->query->andWhere(['tenant_id' => $request['tenant_id'], 'alert_severity' => "Major"]);
                }
                $columns = $searchModel->displayColumns();
                $title = "Major Alert Details";
                break;
            case "critical":
                $searchModel = new NewAlertAnalysisSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                if (!empty($request['tenant_id'])) {
                    $dataProvider->query->andWhere(['tenant_id' => $request['tenant_id'], 'alert_severity' => "critical"]);
                }
                $columns = $searchModel->displayColumns();
                $title = "Critical Alert Details";
                break;
            case "minor":
                $searchModel = new NewAlertAnalysisSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                if (!empty($request['tenant_id'])) {
                    $dataProvider->query->andWhere(['tenant_id' => $request['tenant_id'], 'alert_severity' => "Minor"]);
                }
                print_R($dataProvider->query->createCommand()->getRawSql());
                
                $columns = $searchModel->displayColumns();
                $title = "Minor Alert Details";
                break;
            case "system":
                $searchModel = new SeceonSystemAlertSearch();
                $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                if (!empty($request['tenant_id'])) {
                    $dataProvider->query->andWhere(['tenant_id' => $request['tenant_id']]);
                }
                
                $columns = $searchModel->displayColumns();
                $title = "System Alert Details";
                break;
            default:

                break;
        }
        return ["dataProvider" => $dataProvider, 'columns' => $columns, "title" => $title];
    }
}

/**
//  *     $searchModel = new OptPaymentReconsileSearch();
//         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//         $dataProvider->query->andWhere(['status' => C::INST_PENDING]);

//         return $this->render('optrecon', [
//                     'searchModel' => $searchModel,
//                     'dataProvider' => $dataProvider,
//                     "type" => 1,
//                     "columns" => $searchModel->displayColumn(1),
//                     "title" => "Reconsillation Step 1: Deposit "
//         ]);
 */