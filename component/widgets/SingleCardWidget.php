<?php

namespace app\component\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class SingleCardWidget extends Widget
{

    public $header;
    public $data;
    public $footer;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $header = empty($this->header) ? "" : Html::tag(
            "div",
            Html::tag('h3', $this->title, ["class" => "card-title"]),
            ["class" => "card-header"]
        );

        $footer = empty($this->footer) ? "" : Html::tag("div", $this->footer, ["class" => "card-footer"]);

        $body = Html::tag("div", $this->data, ["class" => "card-body"]);

        return Html::tag(
            "div",
            $header . $body . $footer,
            ["class" => "card card-flush shadow-sm"]
        );
    }

}
