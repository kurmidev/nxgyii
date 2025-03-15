<?php

namespace app\component\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class ListingWidget extends Widget
{
    public $listData;
    public $title;

    public function init()
    {
        parent::init();
        // Initialization code here, if any.
    }

    public function run()
    {

        $content = "";

        foreach ($this->listData as $list) {
            $content .= Html::tag(
                'div',
                Html::tag(
                    "div",
                    Html::tag("div", $list["label"], ["class" => "me-3"]) .
                    Html::tag("div", $list["count"], ["class" => "me-3"]),
                    ["class" => "d-flex flex-stack mb-3"]
                ),
                ["class" => "border border-dashed border-gray-300 rounded px-7 py-3 mb-6"]
            );
        }

        $header = Html::tag(
            'div',
            Html::tag(
                "h3",
                Html::tag("span", $this->title, ["class" => "card-label fw-bold text-gray-900"]),
                ["class" => "card-title align-items-start flex-column"]
            ),
            ["class" => "card-header pt-7"]
        );

        $body = Html::tag(
            'div',
            Html::tag(
                "div",
                $content,
                ["class" => "hover-scroll-overlay-y pe-6 me-n6"]
            )
            ,
            ["class" => "card-body"]
        );

        return Html::tag(
            "div",
            $header.$content,
            ["class" => "card card-flush h-xl-100 mx-auto "]
        );
    }
}
