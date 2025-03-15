<?php

namespace app\component\widgets;

use app\component\Utils;
use yii\web\View;
use yii\base\Widget;
use yii\helpers\Html;

class PieChartWidget extends Widget
{
    public $title;
    public $data;

    public $countData;

    public $showType;

    public $listData;

    public $viewObj;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        if (!empty($this->data)) {
            $this->amCharts();
        }
        $table = "";
        if (!empty($this->listData)) {
            $i = 0;
            $table = "<table class='table table-row-dashed align-middle gs-0 gy-4 my-0'>";
            foreach ($this->listData as $k => $v) {
                if ($i == 0) {
                    $headers = array_keys($v);
                    $h = "";
                    $table.="<theead>";
                    $table.="<tr class='fs-7 fw-bold text-gray-500 border-bottom-0'>";
                    foreach ($headers as $header) {
                        $table .="<th class='pe-0 text-end min-w-100px'>".$header."</th>";
                    }
                    $table.="</tr>";
                }
                $i++;
                $table.="<tr>";
                foreach ($v as $k => $vs) {
                    $table.='<td><span class="text-gray-800 fw-bold d-block fs-6 ps-0 text-end">'.$vs.'</span></td>';
                }
                $table.="</tr>";
            }
            $table.= "</table>";
        }

        return Html::tag(
            "div",
            Html::tag(
                "div",
                Html::tag(
                    "div",
                    Html::tag(
                        "div",
                        Html::tag("span", $this->title, ["class" => "fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2"])
                        ,
                        ["class" => "d-flex align-items-center"]
                    )
                    ,
                    ["class" => "card-title d-flex flex-column"]
                )
                ,
                ["class" => "card-header pt-5"]
            ) .
            Html::tag(
                "div",
                (!empty($this->data) ? Html::tag(
                    "div",
                    Html::tag(
                        "div",
                        Html::tag("div", "", ["id" => "kt_card_widget_4_chart_2", "data-kt-line" => 10, "style" => "height: 200px;width:400px;"]),
                        ["class" => "d-flex flex-center me-5 pt-2"]
                    ),
                    ["class" => "d-flex flex-center me-5 pt-2"]
                ) : "") .
                (!empty($table) ? Html::tag(
                    "div",
                    $table,
                    ["class" => "d-flex flex-column content-justify-center w-100"]
                ) : ""),
                ["class" => "card-body pt-2 pb-4 d-flex align-items-center"]
            ),
            ["class" => "card card-flush h-md-50 mb-5 mb-xl-10"]
        );
    }

    public function amCharts()
    {

        $chartData = [];
        $colorHexArray = [];
        foreach ($this->data as $key => $value) {
            $chartData[] = "{category:'{$value["label"]}',value:{$value["count"]} }";
            $colorHexArray[] = Utils::RandomColorHex();
        }
        $cd = implode(",", $chartData);
        $ch = "'" . implode("','", $colorHexArray) . "'";
        $this->viewObj->registerJsFile("https://cdn.amcharts.com/lib/5/index.js");
        $this->viewObj->registerJsFile("https://cdn.amcharts.com/lib/5/xy.js");
        $this->viewObj->registerJsFile("https://cdn.amcharts.com/lib/5/percent.js");
        $this->viewObj->registerJsFile("https://cdn.amcharts.com/lib/5/themes/Animated.js");
        $script = <<<JSS
        am5.ready(function () {
            // Create root element
            // https://www.amcharts.com/docs/v5/getting-started/#Root_element
            var root = am5.Root.new("kt_card_widget_4_chart_2");
            // Set themes
            // https://www.amcharts.com/docs/v5/concepts/themes/
            root.setThemes([
                am5themes_Animated.new(root)
            ]);
        
            // Create chart
            // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
            var chart = root.container.children.push(am5percent.PieChart.new(root, {
                layout: root.verticalLayout
            }));
        
            // Create series
            // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series
            var series = chart.series.push(am5percent.PieSeries.new(root, {
                alignLabels: true,
                calculateAggregates: true,
                valueField: "value",
                categoryField: "category"
            }));
        
            series.slices.template.setAll({
                strokeWidth: 3,
                stroke: am5.color(0xffffff)
            });
                
            // Set up adapters for variable slice radius
            // https://www.amcharts.com/docs/v5/concepts/settings/adapters/
            series.slices.template.adapters.add("radius", function (radius, target) {
                var dataItem = target.dataItem;
                var high = series.getPrivate("valueHigh");
        
                if (dataItem) {
                    var value = target.dataItem.get("valueWorking", 0);
                    return radius * value / high
                }
                return radius;
            });
        
            // Set data
            // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
            series.data.setAll([$cd]);
        
            // Play initial series animation
            // https://www.amcharts.com/docs/v5/concepts/animations/#Animation_of_series
            series.appear(1000, 100);
        
        }); // end am5.ready()
        JSS;
        $this->viewObj->registerJs($script, View::POS_READY);
    }

    public function googleChart()
    {
        $chartData = [];
        $colorHexArray = [];
        foreach ($this->data as $key => $value) {
            $chartData[] = "['{$value["label"]}',{$value["count"]}]";
            $colorHexArray[] = Utils::RandomColorHex();
        }
        $cd = implode(",", $chartData);
        $ch = "'" . implode("','", $colorHexArray) . "'";
        $this->viewObj->registerJsFile("https://www.gstatic.com/charts/loader.js");
        $script = <<<JSS
                // GOOGLE CHARTS INIT
                google.load('visualization', '1', {
                    packages: ['corechart', 'bar', 'line']
                });
                google.setOnLoadCallback(function () {
                    var data = google.visualization.arrayToDataTable([
                        ['Task', 'Hours per Day'],
                        {$cd}
                    ]);
                    var options = {
                        title: '{$this->title}',
                        colors: [$ch]
                    };
                    console.log("Pie chart",$cd,$ch)
                    var chart = new google.visualization.PieChart(document.getElementById('kt_docs_google_chart_pie'));
                    chart.draw(data, options);
                });
      JSS;
        $this->viewObj->registerJs($script, View::POS_READY);
    }
}