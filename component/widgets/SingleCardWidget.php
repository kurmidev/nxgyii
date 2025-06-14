<?php

namespace app\component\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class SingleCardWidget extends Widget
{

    public $data;
    public $reportName;

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
        $body = Html::tag("div", $counts, ["class" => "card-body"]);

        return Html::tag(
            "div",
            $header . $body,
            ["class" => "card col-lg-3 col-sm-3 col-xs-3 m-1 card-flush shadow-sm"]
        );
       
    }

}
