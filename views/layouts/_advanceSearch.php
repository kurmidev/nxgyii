<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$result = [];

foreach ($search as $s) {
    $field = "";
    switch ($s['type']) {
        case "text":
            $field = Html::activeTextInput($model, $s['attribute'], ['class' => "form-control", "placeholder" => "Enter " . $s['label']]);
            break;
        case "dropdown":
            $field = Html::activeDropDownList($model, $s['attribute'], $s['list'], ['class' => "form-control chosen-select", "prompt" => "select " . $s['label']]);
            break;
        case "date_range":
            $field = Html::activeTextInput($model, $s['attribute'] . "_start", ['class' => "form-control cal", "placeholder" => "Select " . $s['label'] . " start"]);
            $field .= Html::activeTextInput($model, $s['attribute'] . "_end", ['class' => "form-control cal", "placeholder" => "Select " . $s['label'] . " end"]);
            break;
        case "date":
            $field = Html::activeTextInput($model, $s['attribute'], ['class' => "form-control cal", "placeholder" => "select " . $s['label']]);
            break;
    }
    $label = Html::tag("label", $s['label'], ['class' => "form-control-label"]);
    $r = Html::tag("div", $label . $field, ['class' => "form-group"]);
    $result[] = Html::tag("div", $r, ['class' => "col-md-4"]);
}

$show_hide = Html::button('<div><i class="ki-duotone ki-magnifier fs-3 position-absolute ms-3"><span class="path1"></span><span class="path2"></span></i></div>', ["class" => "btn btn-icon-info btn-text-info","style"=>"float:right;margin-right:50px", "onclick" => '$(".searchd").toggle()']);
$submit = Html::submitButton("Search", ["class" => "btn btn-info mr-10"]);
$reset = Html::button("Reset", ["class" => "btn btn-info ml-10", "onclick" => "$('#form-search:input')
  .not(':button, :submit, :reset, :hidden').val('').prop('checked', false).prop('selected', false);"]);

$reset = Html::a("Reset", Yii::$app->urlManager->createUrl(Yii::$app->controller->id . "/" . Yii::$app->controller->action->id), ["class" => "btn btn-info ml-10"]);
$submit = Html::tag("div", $submit . '&nbsp;' . $reset, ["class" => "form-layout-footer bd pd-20 bd-t-0"]);

$searchBody = Html::tag("div",
                Html::tag("div", implode("", $result), ['class' => "row no-gutters"]) .
                $submit, ["class" => "searchd"]
);

$form = ActiveForm::begin(['id' => 'form-search', 'method' => 'get', 'options' => ['enctype' => 'mutipart/form-data']]);
echo Html::tag("div",
        Html::tag("h6", "Search" . $show_hide, ["class" => "tx-gray-800  tx-uppercase tx-bold tx-14 mg-t-10 mg-b-10 pd-10"]) .
        $searchBody, ['class' => "card mg-10 form-layout form-layout-2 "]);

ActiveForm::end();
