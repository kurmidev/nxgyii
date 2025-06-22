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
use DateTime;
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
            $filters = $item['filters'];
            $otherfilter = [];
            if(!empty($item->company_id)){
                $otherfilter['company_id'] = $item->company_id;
                //$otherfilter['fetched_at'] = date("YmdHis",strtotime("-5 minutes"));
            }
            $display_columns = $item["display_columns"];
            $chartData = "";
            if ($item->display_type == Constants::DISPLAY_TYPE_MULPLECARD) {
                $chartData = $this->generateMultiCardData($filters, $display_columns, $collectionName);
            } else if ($item->display_type == Constants::DISPLAY_TYPE_TABLE) {
                $chartData = $this->generateTableData($filters, $display_columns, $collectionName);
            } else {
                $chartData = $this->generateChartData($filters, $display_columns, $collectionName,$otherfilter);
            }
            $graph[$item->id] = $this->generateGraphViews($chartData, $item->report_name, $item->display_type);
        }
        return $graph;
    }

    private function generateWhereConditions($query, $field, $attr, $value)
    {
        if ($value == "<last7daytimestamp>") {
            $date = DateTime::createFromFormat('Y-m-d H:i:s.u', date('Y-m-d H:i:s.u', strtotime("-7 days")));
            $value = (int) ($date->format('Uu') / 1000);
        }
        if ($value == '<currenttimestamp>') {
            $date = DateTime::createFromFormat('Y-m-d H:i:s.u', date('Y-m-d H:i:s.u'));
            $value = (int) ($date->format('Uu') / 1000);
        }
        if ($value == "<last7datetime>") {
            $value = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s', strtotime("-7 days")));
        }
        if ($value == "<last7date>") {
            $value = DateTime::createFromFormat('Y-m-d', date('Y-m-d', strtotime("-7 days")));
        }

        switch ($attr) {
            case 'gt':
                $query->andWhere(['>', $field, $value]);
                break;
            case 'lt':
                $query->andWhere(['<', $field, $value]);
                break;
            case 'eq':
                $query->andWhere([$field => $value]);
                break;
            case 'in':
                $query->andWhere(['in', $field, is_array($value) ? (array) $value : [$value]]);
                break;
            case 'nin':
                $query->andWhere(['not in ', is_array($value) ? (array) $value : [$value]]);
                break;
            case 'between':
                $query->andWhere(['between', $field, $value[0], $value[1]]);
                break;
            default:
                break;
        }
        return $query;
    }

    function generateChartData($filters, $display_columns, $collectionName,$otherfilter=[])
    {
        $label = $action = $value = null;
        $query = (new Query())->from($collectionName);
        if (!empty($filters)) {
            foreach ($filters as $field => $condition) {
                $query = $this->generateWhereConditions($query, $field, $condition["attr"], $condition['val']);
            }
        }
        if (!empty($otherfilter)) {
            $query->andWhere($otherfilter);
        }
        if (!empty($display_columns)) {
            $label = $display_columns['label'];
            $action = $display_columns['action'];
            $value = $display_columns['values'];
            $select = [];
            if (!empty($label)) {
                $select = array_merge($select, [$label]);
            }

            if (!empty($value)) {
                $select = array_merge($select, is_array($value)?$value:[$value]);
            }

            if (!empty($select)) {
                $query->select($select);
            }
        }

        $data = [];
        $queryData = $query->all();
        if (!empty($queryData)) {
            foreach ($queryData as $key => $val) {
                switch ($action) {
                    case 'sum':
                        $data[$val[$label]] = $val[$value] + $data[$val[$label]];
                        break;
                    case 'avg':
                        $data[$val[$label]]['v'] += $val[$value];
                        $data[$val[$label]]['c'] += 1;
                        break;
                    case 'count':
                        if(!empty($val[$label]) && empty($data[$val[$label]]) ) {
                            $data[$val[$label]] = 0;
                        }
                        if(!empty($val[$label])){
                            $data[$val[$label]] += 1;
                        }
                        break;
                    default:
                        break;
                }
            }
        }
        $finalData = [];
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                if ($action == 'avg') {
                    $finalData[] = ["category" => $k, "value" => $v['v'] / $v['c']];
                }
                $finalData[] = ["category" => $k, "value" => $v];
            }
        }
        return $finalData;
    }

    function generateMultiCardData($filters, $display_columns, $collectionName)
    {
        $label = $action = $value = null;
        $query = (new Query())->from($collectionName);
        if (!empty($filters)) {
            foreach ($filters as $field => $condition) {
                $query = $this->generateWhereConditions($query, $field, $condition["attr"], $condition['val']);
            }
        }
        if (!empty($display_columns)) {
            if($display_columns['label']){
                $label = $display_columns['label'];
            }
            $value = !empty($display_columns['value']) ? $display_columns['value'] : [];
            if (!empty($display_columns["values"])) {
                $value = $display_columns["values"];
            }
            $select = [];
            if (!empty($label)) {
                $select = array_merge($select, [$label]);
            }

            if (!empty($value)) {
                $select = array_merge($select, $value);
            }

            if (!empty($select)) {
                $query->select($select);
            }
        }

        $finalData = [];
        $queryData = $query->all();
        $finalData = [];
        if (!empty($queryData)) {
            foreach ($queryData as $key => $val) {
                $res = [];
                foreach ($val as $k => $val) {
                    if (in_array($k, $display_columns['values'])) {
                        $res[$k] = $val;
                    }
                    if ($k == $display_columns['label']) {
                        $label = $val;
                    }
                }
                $finalData[] = [
                    "label" => $label,
                    "value" => $res
                ];
            }
        }
        return $finalData;
    }

    function generateChartDataOld($filters, $display_columns, $collectionName)
    {
        $match = [];
        $group = ['_id' => null];
        $project = [];
        $collection = Yii::$app->mongodb->getCollection($collectionName);

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
                        $match[$field] = ['$in' => is_array($condition['val']) ? (array) $condition['val'] : [$condition['val']]];
                        break;
                    case 'not in':
                        $match[$field] = ['$nin' => is_array($condition['val']) ? (array) $condition['val'] : [$condition['val']]];
                        break;
                    default:
                        $match[$field] = ['$eq' => $condition['val']];
                }
            }
        }

        $query = new Query();
        $query->select($display_columns);
        $query->from($collectionName);
        $query->where($match);
        $data = $query->all();


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

        echo "<pre>Pipeline:\n" . print_r($pipeline, true) . "</pre>";

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

        $columns = $formatted = [];
        $query = (new Query())->from($collectionName);
        if (!empty($filters)) {
            foreach ($filters as $field => $condition) {
                $query = $this->generateWhereConditions($query, $field, $condition["attr"], $condition['val']);
            }
        }
        if (!empty($display_columns)) {
            $columns = is_array($display_columns['values'])
                ? $display_columns['values']
                : [$display_columns['values']];
            $query->select($columns);
        }
        $data = $query->all();
        foreach ($data as $doc) {
            $row = [];
            foreach ($doc as $fieldName => $values) {
                if (in_array($fieldName, $columns)) {
                    $row[$fieldName] = $values;
                }
            }
            $formatted[] = $row;
        }
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

    function generateTableDataOld($filters, $display_columns, $collectionName)
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
                        $match[$field] = ['$in' => is_array($condition['val']) ? (array) $condition['val'] : [$condition['val']]];
                        break;
                    case 'not in':
                        $match[$field] = ['$nin' => is_array($condition['val']) ? (array) $condition['val'] : [$condition['val']]];
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
        echo "<pre>Filter:\n" . print_r($filter, true) . "\nProjection:\n" . print_r($options, true) . "</pre>";

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
