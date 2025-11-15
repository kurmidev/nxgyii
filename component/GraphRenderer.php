<?php
namespace app\component;

use app\component\widgets\BarChartWidget;
use app\component\widgets\LineChartWidget;
use app\component\widgets\ListCardWidget;
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
            if (!empty($item->company_id)) {
                $otherfilter['company_id'] = $item->company_id;
                //$otherfilter['fetched_at'] = date("YmdHis",strtotime("-5 minutes"));
            }
            $display_columns = $item["display_columns"];
            $chartData = "";
            if ($item->display_type == Constants::DISPLAY_TYPE_LISTVIEW) {
                $chartData = $this->generateListViewData($filters, $display_columns, $collectionName);
            } else if ($item->display_type == Constants::DISPLAY_TYPE_TABLE) {
                $chartData = $this->generateTableData($filters, $display_columns, $collectionName);
            } else if ($item->display_type == Constants::DISPLAY_TYPE_MULTIPLECARD) {
                $chartData = $this->generateMultiCardData($filters, $display_columns, $collectionName, $item["id"]);
            } else {
                $chartData = $this->generateChartData($filters, $display_columns, $collectionName, $otherfilter);
            }
            $graph[$item->id] = $this->generateGraphViews($chartData, $item->report_name, $item->display_type);
        }
        return $graph;
    }

    private function generateMultiCardData($filters, $display_columns, $collectionName, $componentId)
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
            if (!empty($display_columns['label'])) {
                $label = $display_columns['label'];
            }
            $action = $display_columns['action'];
            $value = $display_columns['values'];
            $select = [];
            if (!empty($label)) {
                $select = array_merge($select, [$label]);
            }

            if (!empty($value)) {
                $select = array_merge($select, is_array($value) ? $value : [$value]);
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
                        if (!empty($val[$label]) && empty($data[$val[$label]])) {
                            $data[$val[$label]] = 0;
                        }
                        if (!empty($val[$label])) {
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
        return ["data" => $finalData, "collection" => $collectionName, "company_id" => $this->companyId, "componentId" => $componentId];
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

    function generateChartData($filters, $display_columns, $collectionName, $otherfilter = [])
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
                $select = array_merge($select, is_array($value) ? $value : [$value]);
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
                        if (!empty($val[$label]) && empty($data[$val[$label]])) {
                            $data[$val[$label]] = 0;
                        }
                        if (!empty($val[$label])) {
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
        return ["data" => $finalData, "collection" => $collectionName, "company_id" => $this->companyId];
    }

    function generateListViewData($filters, $display_columns, $collectionName)
    {
        $label = $action = $value = null;
        $query = (new Query())->from($collectionName);
        if (!empty($filters)) {
            foreach ($filters as $field => $condition) {
                $query = $this->generateWhereConditions($query, $field, $condition["attr"], $condition['val']);
            }
        }
        if (!empty($display_columns)) {
            if (isset($display_columns['label'])) {
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
                    if (!empty($display_columns['label']) && $k == $display_columns['label']) {
                        $label = $val;
                    }
                }
                $finalData[] = [
                    "label" => $label,
                    "value" => $res
                ];
            }
        }
        return ["data" => $finalData, "collection" => $collectionName, "company_id" => $this->companyId];
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

    public function generateGraphViews($chartData, $reportName, $displayType)
    {
        switch ($displayType) {
            case Constants::DISPLAY_TYPE_TABLE:
                return TableWidget::widget(['dataProvider' => $chartData['dataProvider'], "columns" => $chartData['columns'], 'reportName' => $reportName]);
            case Constants::DISPLAY_TYPE_CARD:
                return SingleCardWidget::widget(["data" => $chartData['data'], "collection" => $chartData['collection'], "company_id" => $chartData["company_id"], 'reportName' => $reportName]);
            case Constants::DISPLAY_TYPE_MULTIPLECARD:
                return MultiCardWidget::widget(["data" => $chartData['data'], "collection" => $chartData['collection'], "company_id" => $chartData["company_id"], 'reportName' => $reportName, "componentId" => $chartData["componentId"]]);
            case Constants::DISPLAY_TYPE_BAR_CHART:
                return BarChartWidget::widget(["data" => $chartData['data'], "collection" => $chartData['collection'], "company_id" => $chartData["company_id"], 'reportName' => $reportName]);
            case Constants::DISPLAY_TYPE_LINE_CHART:
                return LineChartWidget::widget(["data" => $chartData['data'], "collection" => $chartData['collection'], "company_id" => $chartData["company_id"], 'reportName' => $reportName]);
            case Constants::DISPLAY_TYPE_PIE_CHART:
                return PiesChartWidget::widget(["data" => $chartData['data'], "collection" => $chartData['collection'], "company_id" => $chartData["company_id"], 'reportName' => $reportName]);
            case Constants::DISPLAY_TYPE_XY_BUBBLE_CHART:
                return XYBubbleChartWidget::widget(["data" => $chartData['data'], "collection" => $chartData['collection'], "company_id" => $chartData["company_id"], 'reportName' => $reportName]);
            case Constants::DISPLAY_TYPE_LISTVIEW:
                return ListCardWidget::widget(["data" => $chartData['data'], "collection" => $chartData['collection'], "company_id" => $chartData["company_id"], 'reportName' => $reportName]);
            default:
                return null;
        }
    }

}
