<?php
namespace app\component\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Json;

abstract class BaseChartWidget extends Widget
{
    public $chartId;
    public $reportName;
    public $data = []; // Only data is passed
    public $collection;
    public $company_id;

    public function init()
    {
        parent::init();
        if ($this->chartId === null) {
            $this->chartId = 'chart-' . uniqid();
        }
    }

    public function run()
    {
        $this->registerClientScript();
        return Html::tag(
            "div",
            Html::tag(
                "div",
                Html::tag(
                    "div",
                    Html::tag(
                        "div",
                        Html::tag("span", $this->reportName, ["class" => "fs-2hx fw-bold text-gray-900 me-2 lh-1 ls-n2"])
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
                Html::tag(
                    "div",
                    Html::tag(
                        "div",
                        Html::tag("div", "", ["id" => $this->chartId, "data-kt-line" => 10, "style" => "height: 200px;width:400px;"]),
                        ["class" => "d-flex flex-center me-5 pt-2"]
                    ),
                    ["class" => "d-flex flex-center pt-2"]
                ) ,
                ["class" => "card-body pt-2 pb-4 d-flex align-items-center"]
            ),
            ["class" => "card col-lg-12 col-sm-12 col-xs-12 m-2"]
        );


        //return Html::tag('div', '', ['id' => $this->chartId, 'style' => 'width: 100%; height: 400px']);
    }

    abstract protected function getChartInitJs($chartId, $data);

    protected function registerClientScript()
    {
        $view = $this->getView();
        $chartId = $this->chartId;
        $data = Json::encode($this->data);

        $initScript = $this->getChartInitJs($chartId, $data);

        $js = <<<JS
            am5.ready(function() {
                $initScript
            });
        JS;
        $view->registerJsFile("https://cdn.amcharts.com/lib/5/index.js");
        $view->registerJsFile("https://cdn.amcharts.com/lib/5/xy.js");
        $view->registerJsFile("https://cdn.amcharts.com/lib/5/themes/Animated.js");
        $view->registerJs($js);
    }
}
