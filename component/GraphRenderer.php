<?php
namespace app\component;

use app\component\widgets\BarChartWidget;
use app\component\widgets\LineChartWidget;
use app\component\widgets\PiesChartWidget;
use app\component\widgets\TableWidget;
use app\component\widgets\XYBubbleChartWidget;
use app\models\Employee;
use app\models\ProductsApiCompanyMapping;
use app\models\ProductsApiList;
use Yii;
use yii\data\ArrayDataProvider;
use yii\mongodb\Query;

class GraphRenderer
{

    private $companyId;
    private $dashboardType;
    private $isMainDashboard;
    private $employeeId;

    public function __construct($companyId, $dashboardType, $isMainDashboard = false,$employeeId = null)
    {
        $this->companyId = $companyId;
        $this->dashboardType = $dashboardType;
        $this->isMainDashboard = $isMainDashboard;
        $this->employeeId = $employeeId;
    }


    public function render()
    {

        $component = [];

        if(!empty($this->employeeId)){
            $employee = Employee::find()->where(['id'=>$this->employeeId])->one();
            if($employee){
                $component = $employee->component_id;
            }
        }

        $query = ProductsApiCompanyMapping::find()->where([ 'company_id' => $this->companyId])
        ->andFilterWhere(["id"=>$component]);
        if($this->isMainDashboard){
            $query->andWhere(['on_main_dashboard' => 1]);
        }
        if (!empty($this->dashboardType)) {
            $apiList = ProductsApiList::find()->where(['product_id' => $this->dashboardType])->asArray()->all();
            $apiIds = array_column($apiList, 'id');
            $query->andWhere(['api_id' => $apiIds]);
        }
        $model = $query->all();
        
        $graph = [];
        foreach ($model as $item) {
            $collectionName = $item->api->getCollectionName();
            $filters = []; //$item['filters'];
            $display_columns = $item["display_columns"];
            $chartData =
            $item->display_type==Constants::DISPLAY_TYPE_TABLE?
            $this->generateTableData($filters, $display_columns, $collectionName)
            :$this->generateChartData($filters, $display_columns, $collectionName);
            $graph[$item->id] = $this->generateGraphViews($chartData, $item->report_name, $item->display_type);
        }
        return $graph;
    }

    function generateChartData($filters, $display_columns, $collectionName)
    {
        $match = [];
        $group = ['_id' => null];
        $project = [];
        $collection = Yii::$app->mongodb->getCollection($collectionName);

        // Build $match conditions
        if (!empty($filters)) {
            foreach ($filters as $field => $condition) {
                $op = match ($condition['attr']) {
                    'gt' => '$gt',
                    'lt' => '$lt',
                    'gte' => '$gte',
                    'lte' => '$lte',
                    'eq' => '$eq',
                    default => '$eq'
                };
                $match[$field] = [$op => (float) $condition['val']];
            }
        }

        // Identify label and aggregation fields
        $labelField = null;
        if (!empty($display_columns)) {
            if (!empty($display_columns['label'])) {
                $labelField = $display_columns['label'];
                $group['_id'] = '$' . $display_columns['label'];
                $project['category'] = '$_id';
            }
            $field = "";
            if (!empty($display_columns['values']) && !empty($display_columns['action'])) {
                $field = $display_columns['values'];
                $project[$field] = 1;
                switch ($display_columns['action']) {
                    case 'sum':
                        $group[$field] = ['$sum' => '$' . $field];
                        break;
                    case 'count':
                        $group[$field] = ['$sum' => 1];
                        break;
                    case 'min':
                        $group[$field] = ['$min' => '$' . $field];
                        break;
                    case 'max':
                        $group[$field] = ['$max' => '$' . $field];
                        break;
                    case 'avg':
                        $group[$field] = ['$avg' => '$' . $field];
                        break;
                }
            }
        }

        // Assemble pipeline
        if (!empty($match)) {
            $pipeline[] = ['$match' => $match];
        }

        if (!empty($group)) {
            $pipeline[] = ['$group' => $group];
        }

        if (!empty($project)) {
            $pipeline[] = ['$project' => $project];
        }

        // Execute aggregation
        $data = $collection->aggregate($pipeline);

        // Format output
        $formatted = [];
        
        foreach ($data as $doc) {
            $row = [];
            foreach($doc as $fieldName=>$values){
                if($fieldName == '_id'){
                    $row['category'] = $values;
                    continue;
                }
                if($fieldName == 'category'){
                    continue;
                }
                $row['value'] = $values;
            }
            $formatted[] = $row;
        }
        return $formatted;
    }


    function generateTableData($filters, $display_columns, $collectionName)
    {
        $match = [];
        $group = ['_id' => null];
        $project = [];
        $collection = Yii::$app->mongodb->getCollection($collectionName);
        $query = (new Query())->from($collectionName);

        // Build $match conditions
        if (!empty($filters)) {
            foreach ($filters as $field => $condition) {
                $op = match ($condition['attr']) {
                    'gt' => '$gt',
                    'lt' => '$lt',
                    'gte' => '$gte',
                    'lte' => '$lte',
                    'eq' => '$eq',
                    default => '$eq'
                };
                $query->andWhere([$op, $field =>  $condition['val']]);
            }
        }

        // Identify label and aggregation fields
        $labelField = null;
        if (!empty($display_columns)) {
           $query->select(json_decode($display_columns["values"],1));
        }
        // Execute aggregation
        $data = $query->all();
        // Format output
        $formatted = [];
        
        foreach ($data as $doc) {
         $formatted[] = $doc;
        }

        return [
            "dataProvider"=> new ArrayDataProvider([
            'allModels' => $formatted,
            'pagination' => [
                'pageSize' => 10,
            ]
        ]),
            "columns" => $display_columns
        ];
    }


    public function generateGraphViews($chartData, $reportName, $displayType)
    {
        switch ($displayType) {
            case Constants::DISPLAY_TYPE_TABLE:
                return TableWidget::widget(['dataProvider' => $chartData['dataProvider'],"columns"=>$chartData['columns'], 'reportName' => $reportName]);
            case Constants::DISPLAY_TYPE_CARD:
                return;
            case Constants::DISPLAY_TYPE_BAR_CHART:
                return BarChartWidget::widget(['data' => $chartData, 'reportName' => $reportName]);
            case Constants::DISPLAY_TYPE_LINE_CHART:
                return LineChartWidget::widget(['data' => $chartData, 'reportName' => $reportName]);
            case Constants::DISPLAY_TYPE_PIE_CHART:
                return PiesChartWidget::widget(['data' => $chartData, 'reportName' => $reportName]);
            case Constants::DISPLAY_TYPE_XY_BUBBLE_CHART:
                return XYBubbleChartWidget::widget(['data' => $chartData, 'reportName' => $reportName]);
            default:
                return null;
        }
    }

}