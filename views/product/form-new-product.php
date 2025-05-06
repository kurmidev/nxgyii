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
                <div class="col-lg-6 col-sm-6 col-xs-6 mb-5">
                    <?= $form->field($model, 'name', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'name', ['class' => 'input-group-text']); ?>
                    <?= Html::activeTextInput($model, 'name', ['class' => 'form-control form-control-solid ']) ?>
                    <?= Html::error($model, 'name', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2 col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'name')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'code', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'code', ['class' => 'input-group-text']); ?>
                    <?= Html::activeTextInput($model, 'code', ['class' => 'form-control form-control-solid']) ?>
                    <?= Html::error($model, 'code', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'code')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'authentication_type', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'authentication_type', ['class' => 'input-group-text']); ?>
                    <?= Html::activeDropDownList($model, 'authentication_type', Constants::LABEL_AUTH_TYPE, ['class' => 'form-select form-select-solid', 'prompt' => "Select Auth Type"]) ?>
                    <?= Html::error($model, 'authentication_type', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'authentication_type')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'status', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'status', ['class' => 'input-group-text']); ?>
                    <?= Html::activeDropDownList($model, 'status', Constants::LABEL_STATUS, ['class' => 'form-select form-select-solid', 'prompt' => "Select Status"]) ?>
                    <?= Html::error($model, 'status', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'status')->end() ?>
                </div>
                <div class="col-lg-8 col-sm-8 col-xs-8">
                    <?= $form->field($model, 'base_url', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'base_url', ['class' => 'input-group-text']); ?>
                    <?= Html::activeTextInput($model, 'base_url', ['class' => 'form-control form-control-solid']) ?>
                    <?= Html::error($model, 'base_url', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'base_url')->end() ?>
                </div>
                <div class="col-lg-4 col-sm-4 col-xs-4">
                    <?= $form->field($model, 'login_endpoint', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'login_endpoint', ['class' => 'input-group-text']); ?>
                    <?= Html::activeTextInput($model, 'login_endpoint', ['class' => 'form-control form-control-solid']) ?>
                    <?= Html::error($model, 'login_endpoint', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'login_endpoint')->end() ?>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'description', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'description', ['class' => 'input-group-text']); ?>
                    <?= Html::activeTextarea($model, 'description', ['class' => 'form-control form-control-solid']) ?>
                    <?= Html::error($model, 'description', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'description')->end() ?>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-sm-6 col-xs-6">
            <h6 class="br-section-label p-4">Login Headers</h6>
            <?= $this->render("_attributes", ['model' => $model, 'form' => $form, "labelfor" => "login_headers"]) ?>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <h6 class="br-section-label p-4">Auth Headers</h6>
            <?= $this->render("_attributes", ['model' => $model, 'form' => $form, "labelfor" => "auth_headers"]) ?>
        </div>
    </div>

    <div class="card-body row">
        <div class="header-title">Place Holders</div>
        <div class="d-flex flex-column">
            <li class="d-flex align-items-center py-2">
                <span class="bullet me-5"></span> {username} : for username value
            </li>
            <li class="d-flex align-items-center py-2">
                <span class="bullet me-5"></span> {password} : for password value
            </li>
            <li class="d-flex align-items-center py-2">
                <span class="bullet me-5"></span> {token} : for bearer or other token value
            </li>
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