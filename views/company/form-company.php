<?php

use app\component\Constants;
use app\models\ProductMaster;
use app\models\Products;
use app\models\ProductUserMapping;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->isNewRecord) ? 'Add new Company' : 'Update Company ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Company', 'url' => ['Company']];
$this->params['breadcrumbs'][] = $this->title;
$productLists = ArrayHelper::map(Products::find()->active()->all(), 'id', 'name');
?>
<?= $this->render('@app/views/layouts/_contentheader') ?>
<?php $form = ActiveForm::begin(['id' => 'form-company', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'row g-3']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body row g-3">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'name', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'name', ['class' => 'input-group-text']); ?>

                    <?= Html::activeTextInput($model, 'name', ['class' => 'form-control form-control-solid']) ?>
                    <?= Html::error($model, 'name', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>

                    <?= $form->field($model, 'name')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'mobile_no', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'mobile_no', ['class' => ' input-group-text']); ?>

                    <?= Html::activeTextInput($model, 'mobile_no', ['class' => 'form-control form-control-solid', 'maxlength' => 10]) ?>
                    <?= Html::error($model, 'mobile_no', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>

                    <?= $form->field($model, 'mobile_no')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'phone_no', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'phone_no', ['class' => ' input-group-text']); ?>

                    <?= Html::activeTextInput($model, 'phone_no', ['class' => 'form-control form-control-solid', 'maxlength' => 10]) ?>
                    <?= Html::error($model, 'phone_no', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>

                    <?= $form->field($model, 'phone_no')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'email', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'email', ['class' => ' input-group-text']); ?>
                    <?= Html::activeTextInput($model, 'email', ['class' => 'form-control form-control-solid']) ?>
                    <?= Html::error($model, 'email', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'email')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'gst_in', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'gst_in', ['class' => ' input-group-text']); ?>
                    <?= Html::activeTextInput($model, 'gst_in', ['class' => 'form-control form-control-solid']) ?>
                    <?= Html::error($model, 'gst_in', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'gst_in')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'pan_no', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'pan_no', ['class' => ' input-group-text']); ?>
                    <?= Html::activeTextInput($model, 'pan_no', ['class' => 'form-control form-control-solid', 'maxlength' => 10]) ?>
                    <?= Html::error($model, 'pan_no', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'pan_no')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'billing_address', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'billing_address', ['class' => ' input-group-text']); ?>
                    <?= Html::activeTextInput($model, 'billing_address', ['class' => 'form-control form-control-solid']) ?>
                    <?= Html::error($model, 'billing_address', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'billing_address')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'pincode', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'pincode', ['class' => ' input-group-text']); ?>
                    <?= Html::activeTextInput($model, 'pincode', ['class' => 'form-control form-control-solid', 'maxlength' => 6]) ?>
                    <?= Html::error($model, 'pincode', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'pincode')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'status', ['options' => ['class' => "input-group mb-5"]])->begin(); ?>
                    <?= Html::activeLabel($model, 'status', ['class' => ' input-group-text']) ?>
                    <?= Html::activeDropDownList($model, 'status', Constants::LABEL_STATUS, ['class' => 'form-control form-select-solid', 'prompt' => 'Select Status']) ?>
                    <?= Html::error($model, 'status', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2']) ?>
                    <?= $form->field($model, 'status')->end() ?>
                </div>

                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'product_mappings', ['options' => ['class' => "input-group mb-5"]])->begin(); ?>
                    <?= Html::activeLabel($model, 'product_mappings', ['class' => ' input-group-text']) ?>
                    <?= Html::activeDropDownList($model, 'product_mappings', $productLists, ['class' => 'form-control form-select-solid', 'prompt' => "Select one", "multiple" => "multiple", "data-control" => "select2", "value" => $model->getProduct_mappings()]) ?>
                    <?= Html::error($model, 'product_mappings', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2']) ?>
                    <?= $form->field($model, 'product_mappings')->end() ?>
                </div>
            </div>


            <div class="row mt-5">
                <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>