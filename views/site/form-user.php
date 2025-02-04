<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\component\Constants as C;
use app\component\Constants;
use app\models\Designation;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Profile Detail';
$this->params['breadcrumbs'][] = ['label' => 'site', 'url' => ['profile']];
$this->params['breadcrumbs'][] = $this->title;
$isReadonly = isset($isReadonly) ? $isReadonly : FALSE;
?>
<?= $this->render('@app/views/layouts/_contentheader') ?>
<div class="card bd-0 shadow-base widget-14">
    <?php $form = ActiveForm::begin(['id' => 'form-emplyee', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
    <div class="card-body">

        <div class="col-lg-12 col-sm-12 col-xs-12 mb-3">
            <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'name', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeTextInput($model, 'name', ['class' => 'form-control', 'readonly' => $isReadonly]) ?>
                <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'name')->end() ?>
        </div>
        <div class="col-lg-12 col-sm-12 col-xs-12 mb-3">

            <?= $form->field($model, 'mobile_no', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'mobile_no', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeTextInput($model, 'mobile_no', ['class' => 'form-control', 'readonly' => $isReadonly]) ?>
                <?= Html::error($model, 'mobile_no', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'mobile_no')->end() ?>
        </div>
        <div class="col-lg-12 col-sm-12 col-xs-12 mb-3">

            <?= $form->field($model, 'email', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'email', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeTextInput($model, 'email', ['class' => 'form-control', 'readonly' => $isReadonly]) ?>
                <?= Html::error($model, 'email', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'email')->end() ?>
        </div>
        <div class="col-lg-12 col-sm-12 col-xs-12 mb-3">

            <?= $form->field($model, 'designation_id', ['options' => ['class' => "form-group"]])->begin(); ?>
            <?= Html::activeLabel($model, 'designation_id', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?php
                $list = ArrayHelper::map(Designation::find()->asArray()->all(), 'id', 'name');
                ?>
                <?= Html::activeDropDownList($model, 'designation_id', $list, ['class' => 'form-control', 'readonly' => $isReadonly, 'prompt' => "Select Options"]) ?>
                <?= Html::error($model, 'designation_id', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'designation_id')->end() ?>
        </div>
        <div class="col-lg-12 col-sm-12 col-xs-12 mb-3">


            <?= $form->field($model, 'status', ['options' => ['class' => "form-group"]])->begin(); ?>
            <?= Html::activeLabel($model, 'status', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']) ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeDropDownList($model, 'status', Constants::LABEL_STATUS, ['class' => 'form-control', 'readonly' => $isReadonly, 'prompt' => "Select Options"]) ?>
                <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'status')->end() ?>
        </div>
        <div class="col-lg-12 col-sm-12 col-xs-12 mb-3">

            <?= $form->field($model, 'username', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'username', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?php $readonly = $model->id ? TRUE : FALSE ?>
                <?= Html::activeTextInput($model, 'username', ['class' => 'form-control', 'readonly' => $readonly]) ?>
                <?= Html::error($model, 'username', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'username')->end() ?>
        </div>
        <div class="col-lg-12 col-sm-12 col-xs-12 mb-3">
            <?= $form->field($model, 'password', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'password', ['class' => 'col-lg-3 col-sm-3 col-xs-3 control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activePasswordInput($model, 'password', ['class' => 'form-control', 'readonly' => $isReadonly]) ?>
                <?= Html::error($model, 'password', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'password')->end() ?>
        </div>

    </div>

    <div class="card-footer mg-t-auto">
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                <?= Html::submitButton($model->id ? 'Update' : 'Create', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>