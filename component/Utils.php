<?php

namespace app\component;

use DateTime;
use yii\helpers\Html;

class Utils
{
    public static function getStatusLabel($status)
    {
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

    public static function getLabels($label, $values)
    {
        return !empty($label[$values]) ? $label[$values] : null;
    }

    public static function formatHeader($title)
    {
        return ucwords(str_replace(["-", "_"], " ", implode(' ', preg_split('/(?=[A-Z])/', $title))));
    }

    public static function formatNumber($number)
    {
        return number_format((float) $number, 2, '.', '');
    }

    public static function RandomColorHex()
    {
        return '#' . str_pad(dechex(mt_rand(0, 0xFFFFFF)), 6, '0', STR_PAD_LEFT);
    }

    public static function getDayDiff($startDate,$endDate)
    {
        $earlier = new DateTime(date("Y-m-d H:i:s",strtotime($startDate)));
        $later = new DateTime(date("Y-m-d H:i:s",strtotime($endDate)));
        return $later->diff($earlier)->format("%r%a"); //3
    }
}