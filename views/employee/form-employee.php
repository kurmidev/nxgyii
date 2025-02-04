<?php

use app\component\Constants;
use app\models\Company;
use app\models\Designation;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->id) ? 'Add New Employee' : 'Update Employee ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Employee', 'url' => ['employee']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@app/views/layouts/_contentheader') ?>
<?php $form = ActiveForm::begin(['id' => 'form-product', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body row g-3">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6 mb-3">
                    <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'name', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'name', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'name')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6 mb-3">
                    <?= $form->field($model, 'status', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'status', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, 'status', Constants::LABEL_STATUS, ['class' => 'form-control','prompt'=>"Select one"]) ?>
                    <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'status')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6 mb-3">
                    <?= $form->field($model, 'email', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'email', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'email', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'email', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'email')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6 mb-3">
                    <?= $form->field($model, 'password', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'password', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'password', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'password', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'password')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6 mb-3">
                    <?= $form->field($model, 'mobile_no', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'mobile_no', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'mobile_no', ['class' => 'form-control','maxlength'=>10]) ?>
                    <?= Html::error($model, 'mobile_no', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'mobile_no')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6 mb-3">
                    <?= $form->field($model, 'phone_no', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'phone_no', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'phone_no', ['class' => 'form-control','maxlength'=>10]) ?>
                    <?= Html::error($model, 'phone_no', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'phone_no')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6 mb-3">
                    <?= $form->field($model, 'company_id', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'company_id', ['class' => 'control-label']); ?>
                    <?= Html::activeDropDownList($model, "company_id", ArrayHelper::map(Company::find()->active()->all(),"id","name"), ['class' => 'form-control',"prompt"=>"Select one"]) ?>
                    <?= Html::error($model, 'company_id', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'company_id')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6 mb-3">
                    <?= $form->field($model, 'designation_id', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'designation_id', ['class' => 'control-label']); ?>
                <?= Html::activeDropDownList($model, "designation_id", ArrayHelper::map(Designation::find()->active()->all(),"id","name"), ['class' => 'form-control',"prompt"=>"Select one"]) ?>
                    <?= Html::error($model, 'designation_id', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'designation_id')->end() ?>
                </div>
              
                <div class="col-lg-6 col-sm-6 col-xs-6 mb-3">
                    <?= $form->field($model, 'address', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'address', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'address', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'address', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'address')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6 mb-3">
                    <?= $form->field($model, 'pincode', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeLabel($model, 'pincode', ['class' => 'control-label']); ?>
                    <?= Html::activeTextInput($model, 'pincode', ['class' => 'form-control','maxlength'=>6]) ?>
                    <?= Html::error($model, 'pincode', ['class' => 'error help-block']) ?>
                    <?= $form->field($model, 'pincode')->end() ?>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer mg-t-auto">
        <div class="row">
            <div class="col-lg-6 col-sm-6 col-xs-6 mb-3 col-sm-offset-3">
                <?= Html::activeHiddenInput($model, 'id') ?>
                <?= Html::submitButton(empty($model->id) ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
