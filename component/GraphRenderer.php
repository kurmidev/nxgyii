<?php
namespace app\component;

use app\component\widgets\BarChartWidget;
use app\component\widgets\LineChartWidget;
use app\component\widgets\MultiCardWidget;
use app\component\widgets\PiesChartWidget;
use app\component\widgets\SingleCardWidget;
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

    public function __construct($companyId, $dashboardType, $isMainDashboard = false, $employeeId = null)
    {
        $this->companyId = $companyId;
        $this->dashboardType = $dashboardType;
        $this->isMainDashboard = $isMainDashboard;
        $this->employeeId = $employeeId;
    }


    public function render()
    {

        $component = [];

        if (!empty($this->employeeId)) {
            $employee = Employee::find()->where(['id' => $this->employeeId])->one();
            if ($employee) {
                $component = $employee->component_id;
            }
        }

        $query = ProductsApiCompanyMapping::find()->where(['company_id' => $this->companyId])
            ->andFilterWhere(["id" => $component]);
        if ($this->isMainDashboard) {
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
                $item->display_type == Constants::DISPLAY_TYPE_TABLE ?
                $this->generateTableData($filters, $display_columns, $collectionName)
                : $this->generateChartData($filters, $display_columns, $collectionName);
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
            foreach ($doc as $fieldName => $values) {
                if ($fieldName == '_id') {
                    $row['category'] = $values;
                    continue;
                }
                if ($fieldName == 'category') {
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
        $collection = Yii::$app->mongodb->getCollection($collectionName);

        $filter = [];
        $options = [];

        // Build $match conditions
        if (!empty($filters)) {
            foreach ($filters as $field => $condition) {
                switch ($condition['attr']) {
                    case 'gt':
                        $match[$field] = ['$gt' => $condition['val']];
                        break;
                    case 'lt':
                        $match[$field] = ['$lt' => $condition['val']];
                        break;
                    case 'gte':
                        $match[$field] = ['$gte' => $condition['val']];
                        break;
                    case 'lte':
                        $match[$field] = ['$lte' => $condition['val']];
                        break;
                    case 'eq':
                        $match[$field] = ['$eq' => $condition['val']];
                        break;
                    case 'neq':
                        $match[$field] = ['$ne' => $condition['val']];
                        break;
                    case 'in':
                        $match[$field] = ['$in' => is_array($condition['val'])? (array) $condition['val'] : [$condition['val']]];
                        break;
                    case 'not in':
                        $match[$field] = ['$nin' =>  is_array($condition['val'])? (array) $condition['val'] : [$condition['val']]];
                        break;
                    default:
                        $match[$field] = ['$eq' => $condition['val']];
                }
            }
        }

        // Setup projection (i.e., select fields to return)
        $columns = is_array($display_columns['values'])
            ? $display_columns['values']
            : [$display_columns['values']];


        // DEBUG: print filter and projection
        // echo "<pre>Filter:\n" . print_r($filter, true) . "\nProjection:\n" . print_r($options, true) . "</pre>";

        // Execute the query
        $cursor = $collection->find($filter, $options);
        $data = iterator_to_array($cursor, true); // true = use_keys

        $formatted = [];
        foreach ($data as $doc) {
            $row = [];
            foreach ($doc as $fieldName => $values) {
                if (in_array($fieldName, ['_id', 'fetchd_at', "company_id"])) {
                    continue;
                }
                if (in_array($fieldName, $columns)) {
                    $row[$fieldName] = $values;
                }
            }
            $formatted[] = $row;
        }
        // DEBUG: print one row
        // echo "<pre>Data Sample:\n" . print_r($data[0] ?? [], true) . "</pre>";

        return [
            "dataProvider" => new ArrayDataProvider([
                'allModels' => $data,
                'pagination' => [
                    'pageSize' => 10,
                ]
            ]),
            "columns" => $columns
        ];
    }


    public function generateGraphViews($chartData, $reportName, $displayType)
    {
        switch ($displayType) {
            case Constants::DISPLAY_TYPE_TABLE:
                return TableWidget::widget(['dataProvider' => $chartData['dataProvider'], "columns" => $chartData['columns'], 'reportName' => $reportName]);
            case Constants::DISPLAY_TYPE_CARD:
                return SingleCardWidget::widget(['data' => $chartData, 'reportName' => $reportName]);
            case Constants::DISPLAY_TYPE_MULPLECARD:
                return MultiCardWidget::widget(['data' => $chartData, 'reportName' => $reportName]);
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