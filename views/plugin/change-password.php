<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'Change Password';
$this->params['breadcrumbs'][] = ['label' => 'Plugin', 'url' => ['Company']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('@app/views/layouts/_contentheader') ?>
<?php $form = ActiveForm::begin(['id' => 'form-company', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'row g-3']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body row g-3">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'password', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'password', ['class' => 'input-group-text']); ?>

                    <?= Html::activeTextInput($model, 'password', ['class' => 'form-control form-control-solid']) ?>
                    <?= Html::error($model, 'password', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>

                    <?= $form->field($model, 'password')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'confirmpassword', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'confirmpassword', ['class' => ' input-group-text']); ?>

                    <?= Html::activeTextInput($model, 'confirmpassword', ['class' => 'form-control form-control-solid', 'maxlength' => 10]) ?>
                    <?= Html::error($model, 'confirmpassword', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>

                    <?= $form->field($model, 'confirmpassword')->end() ?>
                </div>
            </div>
            <div class="row mt-5">
                <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                    <?= Html::submitButton("Change Password", ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>