<?php

use app\component\Constants;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id) ? 'Add New Product' : 'Update Product ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Product', 'url' => ['product']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@app/views/layouts/_contentheader') ?>
<?php $form = ActiveForm::begin(['id' => 'form-product', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'name', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'name', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'name')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'service_provider', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'service_provider', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'service_provider', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'service_provider', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'service_provider')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'description', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'description', ['class' => 'control-label']); ?>
                    <?= Html::activeTextarea($model, 'description', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'description', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'description')->end() ?>
                </div>
                <div class="col-lg-3 col-sm-3 col-xs-3">
                    <?= $form->field($model, 'status', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'status', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'status', Constants::LABEL_STATUS, ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'status')->end() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body row">
        <div class="col-lg-12 col-sm-12 col-xs-12 mb-5">
            <h6 class="br-section-label p-4">Pool Details</h6>
            <?= $this->render('_product_attributes', ['model' => $model, 'form' => $form]) ?>
        </div>
    </div>
    <div class="card-footer mg-t-auto">
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                <?= Html::activeHiddenInput($model, 'id') ?>
                <?= Html::submitButton(empty($model->id) ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
