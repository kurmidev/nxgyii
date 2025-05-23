<?php

use app\component\Constants;
use app\models\Designation;
use app\models\ProductMaster;
use app\models\Products;
use app\models\ProductUserMapping;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$designationList = ArrayHelper::map(
    Designation::find()->active()->all(),
    'id',
    'name'
);

$this->title = ($model->isNewRecord) ? 'Add new User' : 'Update User ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'User', 'url' => ['User']];
$this->params['breadcrumbs'][] = $this->title;
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
                    <?= $form->field($model, 'email', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'email', ['class' => ' input-group-text']); ?>
                    <?= Html::activeTextInput($model, 'email', ['class' => 'form-control form-control-solid']) ?>
                    <?= Html::error($model, 'email', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'email')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'status', ['options' => ['class' => "input-group mb-5"]])->begin(); ?>
                    <?= Html::activeLabel($model, 'status', ['class' => ' input-group-text']) ?>
                    <?= Html::activeDropDownList($model, 'status', Constants::LABEL_STATUS, ['class' => 'form-control form-select-solid', 'prompt' => 'Select Status']) ?>
                    <?= Html::error($model, 'status', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2']) ?>
                    <?= $form->field($model, 'status')->end() ?>
                </div>

                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'designation_id', ['options' => ['class' => "input-group mb-5"]])->begin(); ?>
                    <?= Html::activeLabel($model, 'designation_id', ['class' => ' input-group-text']) ?>
                    <div class="col-lg-6 col-sm-6 col-xs-6">
                        <?= Html::activeDropDownList($model, 'designation_id', $designationList, ['class' => 'form-control form-select-solid', 'prompt' => "Select one"]) ?>
                        <?= Html::error($model, 'designation_id', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2']) ?>
                    </div>
                    <?= $form->field($model, 'designation_id')->end() ?>
                </div>
                <?php  if ($model->isNewRecord) { ?>
                    <div class="col-lg-6 col-sm-6 col-xs-6">
                        <?= $form->field($model, 'username', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                        <?= Html::activeLabel($model, 'username', ['class' => ' input-group-text']); ?>
                        <?= Html::activeTextInput($model, 'username', ['class' => 'form-control form-control-solid']) ?>
                        <?= Html::error($model, 'username', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                        <?= $form->field($model, 'username')->end() ?>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-xs-6">
                        <?= $form->field($model, 'password', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                        <?= Html::activeLabel($model, 'password', ['class' => ' input-group-text']); ?>
                        <?= Html::activePasswordInput($model, 'password', ['class' => 'form-control form-control-solid']) ?>
                        <?= Html::error($model, 'password', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                        <?= $form->field($model, 'password')->end() ?>
                    </div>

                    <div class="col-lg-6 col-sm-6 col-xs-6">
                        <?= $form->field($model, 'confirmpassword', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                        <?= Html::activeLabel($model, 'confirmpassword', ['class' => ' input-group-text']); ?>
                        <?= Html::activePasswordInput($model, 'confirmpassword', ['class' => 'form-control form-control-solid', 'maxlength' => 10]) ?>
                        <?= Html::error($model, 'confirmpassword', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                        <?= $form->field($model, 'confirmpassword')->end() ?>
                    </div>
                <?php } ?>
            </div>

            <div class="row mt-5">
                <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>