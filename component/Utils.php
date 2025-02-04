<?php

namespace app\component;

use yii\helpers\Html;

class Utils {
    public static function getStatusLabel($status) {
        switch ($status) {
            case Constants::STATUS_ACTIVE:
                return Html::tag('span', 'Active', ['class' => 'badge bg-success']);
            case Constants::STATUS_INACTIVE:
                return Html::tag('span', 'In Active', ['class' => 'badge bg-warning']);
            case Constants::STATUS_DELETED:
                return Html::tag('span', "Deleted", ['class' => 'badge bg-secondary']);
            default:
                return "";
        }
    }

    public static function getLabels($label, $values) {
        return !empty($label[$values]) ? $label[$values] : null;
    }

    public static function formatHeader($title) {
        return ucwords(str_replace(["-", "_"], " ", implode(' ', preg_split('/(?=[A-Z])/', $title))));
    }

    public static function formatNumber($number) {
        return number_format((float) $number, 2, '.', '');
    }

}