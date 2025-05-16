<?php

namespace app\component\widgets;

use yii\base\Widget;

class TableWidget extends Widget
{

    public $reportName;
    public $data = [];

    public function init()
    {
        parent::init();

    }
    public function run()
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