<?php

use app\component\Constants;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Reason;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->isNewRecord) ? 'Add new Company' : 'Update Company ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Company', 'url' => ['Company']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@app/views/layouts/_contentheader') ?>
<?php $form = ActiveForm::begin(['id' => 'form-company', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'row g-3']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body row g-3">
        <div class="col-md-6">
            <?= $form->field($model, 'name', ['options' => ['class' => 'form-group ']])->begin() ?>
            <?= Html::activeLabel($model, 'name', ['class' => ' control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeTextInput($model, 'name', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'name')->end() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'mobile_no', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'mobile_no', ['class' => ' control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeTextInput($model, 'mobile_no', ['class' => 'form-control', 'maxlength' => 10]) ?>
                <?= Html::error($model, 'mobile_no', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'mobile_no')->end() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'phone_no', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'phone_no', ['class' => ' control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeTextInput($model, 'phone_no', ['class' => 'form-control', 'maxlength' => 10]) ?>
                <?= Html::error($model, 'phone_no', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'phone_no')->end() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'email', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'email', ['class' => ' control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeTextInput($model, 'email', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'email', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'email')->end() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'gst_in', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'gst_in', ['class' => ' control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeTextInput($model, 'gst_in', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'gst_in', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'gst_in')->end() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'pan_no', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'pan_no', ['class' => ' control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeTextInput($model, 'pan_no', ['class' => 'form-control', 'maxlength' => 10]) ?>
                <?= Html::error($model, 'pan_no', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'pan_no')->end() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'billing_address', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'billing_address', ['class' => ' control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeTextInput($model, 'billing_address', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'billing_address', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'billing_address')->end() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'pincode', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'pincode', ['class' => ' control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeTextInput($model, 'pincode', ['class' => 'form-control', 'maxlength' => 6]) ?>
                <?= Html::error($model, 'pincode', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'pincode')->end() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'status', ['options' => ['class' => "form-group"]])->begin(); ?>
            <?= Html::activeLabel($model, 'status', ['class' => ' control-label']) ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeDropDownList($model, 'status', Constants::LABEL_STATUS, ['class' => 'form-control']) ?>
                <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'status')->end() ?>
        </div>

        <div class="row mt-5">
            <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>