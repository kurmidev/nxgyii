<?php

namespace app\component;

use DateTime;
use Exception;
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

    public static function getDayDiff($startDate, $endDate)
    {
        $earlier = new DateTime(date("Y-m-d H:i:s", strtotime($startDate)));
        $later = new DateTime(date("Y-m-d H:i:s", strtotime($endDate)));
        return $later->diff($earlier)->format("%r%a"); //3
    }

    public static function prefixNumber($number)
    {
        // If the number is greater than or equal to a lakh (100,000)
        $number = str_replace(",", '', $number);

        try {
            if ($number >= 100000) {
                // Format to Lakhs (L) with two decimal points
                return number_format($number / 100000, 1) . 'L';
            }
            // If the number is greater than or equal to a thousand (1000) but less than 100000
            elseif ($number >= 1000) {
                // Format to Thousands (K) with one decimal point
                return number_format($number / 1000, 1) . 'K';
            }
            // If the number is less than 1000, return the number as is
            else {
                return $number;
            }
        } catch (Exception $ex) {
            print_r($number);
            exit;
        }

    }

    public static function getDropDownButton($buttonLists)
    {
        $cont = "";
        $button = Html::a("Action" . Html::tag("i", "", ["class" => "ki-duotone ki-down fs-2"]), "#", $options = [
            "class" => "btn btn-sm btn-icon btn-light btn-active-light-primary",
            "data-kt-menu-trigger" => "click",
            "data-kt-menu-placement" => "bottom-start"
        ]);
        foreach ($buttonLists as $p) {
            $cont .= Html::tag(
                "div",
                Html::a($p["name"], $p["url"], ["class" => "menu-link px-3", "data-kt-inbox-listing-filter" => "show_all"]),
                ["class" => "menu-item px-3"]
            );
        }
        $listWrapper = Html::tag('div', $cont, ['class' => 'menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4', "data-kt-menu" => "true"]);
        return Html::tag('div', $button . $listWrapper, ['class' => 'menu-item px-3']);
    }

    public static function getInitialWithRandomColor($name)
    {
        $name = str_replace(" ", "", $name);
        $color = Utils::RandomColorHex();
        $initial = substr($name, 0, 2);
        return Html::tag("div", $initial, ["class" => "symbol-label fs-1 fw-bold bg-light-{$color} text-{$color}"]);
    }

    public static function timeAgo($datetime, $full = false): string
    {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        // Calculate total weeks from days separately (without modifying $diff)
        $weeks = floor($diff->d / 7);
        $days = $diff->d % 7;

        $string = [
            'y' => $diff->y,
            'm' => $diff->m,
            'w' => $weeks,
            'd' => $days,
            'h' => $diff->h,
            'i' => $diff->i,
            's' => $diff->s,
        ];

        $labels = [
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        ];

        $parts = [];

        foreach ($string as $key => $value) {
            if ($value) {
                $parts[] = "$value " . $labels[$key] . ($value > 1 ? 's' : '');
            }
        }

        if (!$full) {
            $parts = array_slice($parts, 0, 1);
        }

        return $parts ? implode(', ', $parts) . ' ago' : 'just now';
    }

    public static function getEndDate($date)
    {
        return date("Y-m-d 23:59:59", strtotime($date));
    }

    public static function allValuesAreNumbersOrDates(array $values): bool
    {
        foreach ($values as $value) {
            if(!empty($value)){
                continue;
            }
            // Check if value is numeric
            if (is_numeric($value)) {
                continue;
            }
            // Check if value is a valid date (try parsing with strtotime)
            if (!empty($value) && strtotime($value) !== false) {
                continue;
            }
            // If it's neither, return false
            return false;
        }
        return true;
    }


}