<?php

namespace app\component\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class MultiCardWidget extends Widget
{

    public $data;
    public $reportName;

    public function init()
    {
        parent::init();
    }

    public function run()
    {

        $display = "";
        if (is_array($this->data)) {
            foreach ($this->data as $key => $value) {
                $header = Html::tag(
                    "div",
                    Html::tag('h3', $value["category"], ["class" => "card-title"]),
                    ["class" => "card-header"]
                );
                //$footer = empty($this->footer) ? "" : Html::tag("div", $this->footer, ["class" => "card-footer"]);
                $body = Html::tag("div", $value["value"], ["class" => "card-body"]);

                $display .= Html::tag(
                    "div",
                    $header . $body,
                    ["class" => "card col-lg-3 col-sm-3 col-xs-3 m-1 card-flush shadow-sm"]
                );
            }

        }
        return Html::tag(
                    "div",
                    $display,
                    ["class" => " row "]
                );;
    }

}
