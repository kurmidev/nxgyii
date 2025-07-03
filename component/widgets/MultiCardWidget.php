<?php

namespace app\component\widgets;
use app\component\Utils;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class MultiCardWidget extends Widget
{

    public $data;
    public $reportName;
    public $collection;
    public $company_id;

    public $componentId;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $content = [];
        
        foreach ($this->data as $key => $value) {
            $content[] = Html::tag(
                "div",
                Html::tag(
                    "div",
                    $value['value'],
                    ["class" => "d-flex align-items-center"]
                ) .
                Html::tag("div", Utils::convertToHeaderCase($value['category']), ["class" => "fw-semibold fs-6"]),
                ["class" => "border border-gray-300 border-dashed rounded min-w-200px py-3 px-4 me-6 mb-3"]
            );
        }

        $body = Html::tag(
            "div",
            Html::a(
                implode($content),
                Yii::$app->urlManager->createUrl(["company/dashboard-detail", "col" => $this->collection, "company_id" => $this->company_id, "view" => "tabs","comp"=>$this->componentId]),
            ),
            ["class" => "card-body p-0"]
        );


        $header = Html::tag(
            "div",
            Html::tag('h3', $this->reportName, ["class" => "card-title"]),
            ["class" => "card-header"]
        );

        return Html::tag(
            "div",
            $header . $body,
            ["class" => "card shadow-sm"]
        );
    }

}