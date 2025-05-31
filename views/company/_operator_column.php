<?php

use app\component\Constants;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
if (
    in_array($model->display_type, [
        Constants::DISPLAY_TYPE_BAR_CHART,
        Constants::DISPLAY_TYPE_LINE_CHART,
        Constants::DISPLAY_TYPE_PIE_CHART,
        Constants::DISPLAY_TYPE_XY_BUBBLE_CHART,
        Constants::DISPLAY_TYPE_CARD,
        Constants::DISPLAY_TYPE_MULPLECARD
    ])
) {

    $label = Html::tag('div', Html::tag('label', 'Category', ['class' => 'form-label']), ['class' => 'col-lg-6 col-sm-6 col-xs-6']);

    $inputs = Html::tag(
        "div",
        Html::activeDropDownList(
            $model,
            'display_columns[label]',
            ArrayHelper::map($apiData, 'key', 'key'),
            ['class' => 'form-control form-control-solid', "prompt" => "select one"]
        ),
        ['class' => 'col-lg-6 col-sm-6 col-xs-6']
    );

    $row1 = Html::tag('div', $label . $inputs, ['class' => 'row mb-2']);

    $label = Html::tag('div', Html::tag('label', 'Values', ['class' => 'form-label']), ['class' => 'col-lg-6 col-sm-6 col-xs-6']);

    $inputs = Html::tag(
        "div",
        Html::activeDropDownList(
            $model,
            'display_columns[values]',
            ArrayHelper::map($apiData, 'key', 'key'),
            ['class' => 'form-control form-control-solid', "prompt" => "select one"]
        ),
        ['class' => 'col-lg-6 col-sm-6 col-xs-6']
    );

    $row2 = Html::tag('div', $label . $inputs, ['class' => 'row mb-2']);


    $label = Html::tag('div', Html::tag('label', 'Actions', ['class' => 'form-label']), ['class' => 'col-lg-6 col-sm-6 col-xs-6']);

    $inputs = Html::tag(
        "div",
        Html::activeDropDownList($model, 'display_columns[action]', [
            'max' => 'Max',
            'min' => 'Min',
            'sum' => 'SUM',
            'avg' => 'AVG',
            'count' => 'COUNT',
        ], ['class' => 'form-control form-control-solid', "prompt" => "select one"]),
        ['class' => 'col-lg-6 col-sm-6 col-xs-6']
    );

    $row3 = Html::tag('div', $label . $inputs, ['class' => 'row mb-2']);

    echo $row1 . $row2 . $row3;

} else if ($model->display_type == Constants::DISPLAY_TYPE_TABLE) {

    $label = Html::tag(
        'div',
        Html::tag('label', 'Fields List', ['class' => 'form-label']),
        ['class' => 'col-lg-6 col-sm-6 col-xs-6']
    );
    $inputs = Html::tag(
        "div",
        Html::activeDropDownList(
            $model,
            'display_columns[values]',
            ArrayHelper::map($apiData, 'key', 'key'),
            ['class' => 'form-control form-control-solid', "multiple"=>true]
        ),
        ['class' => 'col-lg-6 col-sm-6 col-xs-6']
    );
    echo Html::tag("div", $label.$inputs, ['class' => 'row mb-2']);

}