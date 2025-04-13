<?php

use app\component\Constants;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->isNewRecord) ? 'Add new Category' : 'Update Category ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Category', 'url' => ['Category']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@app/views/layouts/_contentheader') ?>
<?php $form = ActiveForm::begin(['id' => 'form-company', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'row g-3']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body row g-3">
        <div class="col-md-6">
            <?= $form->field($model, 'name', ['options' => ['class' => 'form-group ']])->begin() ?>
            <?= Html::activeLabel($model, 'name', ['class' => ' control-label']); ?>
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <?= Html::activeTextInput($model, 'name', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'name')->end() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'type', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'type', ['class' => ' control-label']); ?>
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <?= Html::activeDropDownList($model, 'type', Constants::LABEL_CATEGORY_TYPE, ['class' => 'form-control','prompt'=>"Select one"]) ?>
                <?= Html::error($model, 'type', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'type')->end() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'description', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'description', ['class' => ' control-label']); ?>
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <?= Html::activeTextarea($model, 'description', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'description', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'description')->end() ?>
        </div>

        <div class="col-md-6">
            <?= $form->field($model, 'status', ['options' => ['class' => "form-group"]])->begin(); ?>
            <?= Html::activeLabel($model, 'status', ['class' => ' control-label']) ?>
            <div class="col-lg-12 col-sm-12 col-xs-12">
                <?= Html::activeDropDownList($model, 'status', Constants::LABEL_STATUS, ['class' => 'form-control','prompt'=>"Select one"]) ?>
                <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'status')->end() ?>
        </div>

        <div class="row mt-5">
            <div class="col-lg-12 col-sm-12 col-xs-12 col-sm-offset-3">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>