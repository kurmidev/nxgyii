<?php

namespace app\component\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class CountWidget extends Widget
{
    public $count;
    public $title;
    public $type;
    public $url;
    private $iconsList = [
        "ki-chart-pie-4",
        "ki-element-11",
        "ki-package",
        "ki-chart-line-star",
        "ki-chart-simple-3",
        "ki-call"
    ];


    public function init()
    {
        parent::init();
    }

    private function getIcons()
    {

        $iconsImage = $this->iconsList[rand(0, count($this->iconsList) - 1)];
        return '<i class="ki-duotone ' . $iconsImage . ' fs-4x text-primary mb-3 pulse">
        <span class="path1"></span>
        <span class="path2"></span>
        <span class="path3"></span>
        <span class="path4"></span>
    </i>';
    }

    public function run()
    {
        return $this->type == "circle" ? $this->Circle() : $this->Square();
    }

    function Circle()
    {
        $icons = $this->getIcons();
        $cnt = $this->count;
        if(!empty($this->url)){
            $cnt = Html::tag("a",$this->count,["href"=>$this->url]);
        }
        return Html::tag(
            'div',
            Html::tag(
                "div",
                Html::tag("span", $icons, ["class", "fs-4x text-primary mb-3"]) .
                Html::tag(
                    "div",
                    Html::tag(
                        "div",
                        Html::tag("div", $cnt, ["class" => "min-w-70px fw-semibold", "data-kt-countup" => "true", "data-kt-countup-value" => $this->count, "data-kt-countup-suffix" => "+"])
                        ,
                        ["class" => "fs-lg-2hx fs-2x fw-bold text-gray-800 d-flex flex-center"]
                    ) .

                    Html::tag("span", $this->title, ["class" => "text-gray-600 fw-semibold fs-5 lh-0"])

                    ,
                    ["class" => "mb-0"]
                )
                ,
                ["class" => "d-flex flex-column flex-center h-200px w-200px h-lg-200px w-lg-200px m-3 bg-light rounded-circle"]
            ),
            ["class" => 'd-flex flex-wrap flex-center justify-content-lg-between mx-auto w-xl-900px']
        );
    }

    private function Square()
    {
        $icons = $this->getIcons();
        $cnt = Html::tag(
            "div",
            Html::tag("div", $this->count, ["class" => "min-w-70px fw-semibold", "data-kt-countup" => "true", "data-kt-countup-value" => $this->count, "data-kt-countup-suffix" => "+"])
            ,
            ["class" => "fs-lg-2hx fs-2x fw-bold text-gray-800 d-flex flex-center"]
        );
        if(!empty($this->url)){
            $cnt = Html::tag("a",$cnt,["href"=>$this->url]);
        }
        return  Html::tag(
            "div",
            Html::tag(
                "div",
                Html::tag("span", $icons, ["class" => "svg-icon fs-3 text-success me-2"]) .
                $cnt
                ,
                ["class" => "d-flex align-items-center"]
            ) .
            Html::tag("div", $this->title, ["class" => "fw-semibold fs-6"])
            ,
            ["class" => "border border-gray-300 border-dashed rounded min-w-200px py-3 px-4 me-6 mb-3"]
        );
    }

}
