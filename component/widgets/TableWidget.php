<?php

namespace app\component\widgets;

use app\component\CtGridView;
use yii\base\Widget;
use yii\helpers\Html;

class TableWidget extends Widget
{

    public $reportName;
    public $dataProvider;
    public $columns;

    public function init()
    {
        parent::init();

    }

    public function run()
    {

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
            CtGridView::widget([
                'dataProvider' => $this->dataProvider,
                'columns' => $this->columns["values"]
            ])
            ,
            ["class" => "card mb-5"]
        );

    }
    public function runOld()
    {
        $table = "";
        if (!empty($this->data)) {
            $i = 0;
            $table = "<table class='table align-middle responsive gs-0 gy-4 my-0'>";
            foreach ($this->data as $values) {
                if ($i == 0) {
                    $headers = array_keys($values);
                    $table .= "<thead>";
                    $table .= "<tr class='fw-bold fs-6 text-gray-800'>";
                    foreach ($headers as $header) {
                        $table .= "<th class='pe-0 text-end min-w-10px'>" . $header . "</th>";
                    }
                    $table .= "</tr>";
                    $table .= "</thead>";
                    $table .= "<tbody>";
                }
                $i++;
                $table .= "<tr>";
                foreach ($values as $value) {
                    $table .= "<td class='pe-0 text-end min-w-10px'>" . $value . "</td>";
                }
                $table .= "</tr>";
            }
            $table .= "</table>";
        }
        return $table;
    }
}