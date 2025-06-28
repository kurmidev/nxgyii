<?php

namespace app\component\widgets;

use Yii;
use yii\base\Widget;
use yii\helpers\Html;

class SingleCardWidget extends Widget
{

    public $data;
    public $reportName;
    public $collection;
    public $company_id;


    public function init()
    {
        parent::init();
    }

    public function run()
    {

        $counts = 0;
        if (is_array($this->data)) {
            foreach ($this->data as $key => $value) {
                $counts += $value["value"];
            }
        }
        $header = Html::tag(
            "div",
            Html::tag('h3', $this->reportName, ["class" => "card-title"]),
            ["class" => "card-header"]
        );
        $body = Html::tag(
            "div",
            Html::a(
                Html::tag("span", $counts, ["class" => "text-gray-900 fw-bolder fs-6"]),
                Yii::$app->urlManager->createUrl(["company/dashboard-detail", "col" => $this->collection, "company_id" => $this->company_id]),
            ),
            ["class" => "card-body"]
        );

        return Html::tag(
            "div",
            $header . $body,
            ["class" => "card col-lg-3 col-sm-3 col-xs-3 m-1 card-flush shadow-sm"]
        );

    }

}
