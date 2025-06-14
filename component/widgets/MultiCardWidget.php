<?php

namespace app\component\widgets;

use app\component\Utils;
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

        $display = [];
        
        if (is_array($this->data)) {
            foreach ($this->data as $key => $value) {
                $dis = "";
                foreach ($value['value'] as $k => $v) {
                    $header = Html::tag(
                        "div",
                        Utils::convertToHeaderCase($k),
                        ["class" => "text-gray-700 fw-semibold fs-6 me-2"]
                    );
                    $body = Html::tag(
                        "div",
                        Html::tag("span", $v, ["class" => "text-gray-900 fw-bolder fs-6"]),
                        ["class" => "d-flex align-items-senter"]
                    );

                    $dis .= Html::tag(
                        "div",
                        $header . $body,
                        ["class" => "d-flex flex-stack"]
                    ). Html::tag("div", "", ["class" => "separator separator-dashed my-3"]);
                }
                $cardBody = Html::tag(
                    "div",
                    $dis,
                    ["class" => "card-body pt-5"]
                ) ;
                $cardHead = Html::tag(
                    "div",
                    Html::tag(
                        "h3",
                        Html::tag("span", $value['label'], ["class" => "card-label fw-bold text-gray-900"]),
                        ["class" => "card-title align-items-start flex-column"]
                    ),
                    ["class" => "card-header pt-5"]
                );
                $display[] = Html::tag(
                    "div",
                    Html::tag(
                        "div",
                        $cardHead . $cardBody,
                        ["class" => "card card-flush h-lg-100"]
                    ),
                    ["class" => "col-sm-4 mb-5 mb-xl-10"]
                );
            }
        }
        return implode("", $display);
    }

}
