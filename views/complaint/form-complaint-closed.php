<?php

use app\component\Constants;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<?php $form = ActiveForm::begin(['id' => 'form-complaint-reply', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'row g-3']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body row g-3">
        <div class="col-md-12">
            <?= $form->field($model, 'resolution', ['options' => ['class' => 'form-group ']])->begin() ?>
            <?= Html::activeLabel($model, 'resolution', ['class' => ' control-label']); ?>
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <?= Html::activeTextarea($model, 'resolution', ['class' => 'form-control form-control-solid placeholder-gray-600 fw-bold fs-4 ps-9 pt-7',"row"=>200,"cols"=>200]) ?>
                <?= Html::error($model, 'resolution', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'resolution')->end() ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'status', ['options' => ['class' => 'form-group ']])->begin() ?>
            <?= Html::activeLabel($model, 'status', ['class' => ' control-label']); ?>
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <?= Html::activeDropDownList($model, 'status',[Constants::CLOSED=>"Closed",Constants::ON_HOLD=>"On Hold"], ['class' => 'form-control form-control-solid placeholder-gray-600 fw-bold fs-4 ps-9 pt-7','prompt'=>'Select Status']) ?>
                <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'status')->end() ?>
        </div>
        <div class="row mt-5">
            <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                <?= Html::submitButton('Close', ['class' => 'btn btn-primary mt-n0 mb-20 position-relative float-end me-7']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>