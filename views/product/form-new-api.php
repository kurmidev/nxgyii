<?php

use app\component\Constants;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = ($model->id) ? 'Add New Product' : 'Update Product ' . $model->api_name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Product', 'url' => ['product']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?= $this->render('@app/views/layouts/_contentheader') ?>
<?php $form = ActiveForm::begin(['id' => 'form-api', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body row">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6 mb-5">
                    <?= $form->field($model, 'api_name', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'api_name', ['class' => 'input-group-text']); ?>
                    <?= Html::activeTextInput($model, 'api_name', ['class' => 'form-control form-control-solid ']) ?>
                    <?= Html::error($model, 'api_name', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2 col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'api_name')->end() ?>
                </div>

                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'api_endpoint', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'api_endpoint', ['class' => 'input-group-text']); ?>
                    <?= Html::activeTextInput($model, 'api_endpoint', ['class' => 'form-control form-control-solid']) ?>
                    <?= Html::error($model, 'api_endpoint', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'api_endpoint')->end() ?>
                </div>

                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'api_endpoint', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'api_endpoint', ['class' => 'input-group-text']); ?>
                    <?= Html::activeDropDownList($model, 'api_method',Constants::LABEL_METHOD_TYPE, ['class' => 'form-select form-select-solid','prompt'=>"Select Method"]) ?>
                    <?= Html::error($model, 'api_endpoint', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'api_endpoint')->end() ?>
                </div>

                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'status', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'status', ['class' => 'input-group-text']); ?>
                    <?= Html::activeDropDownList($model, 'status', Constants::LABEL_STATUS, ['class' => 'form-select form-select-solid', 'prompt' => "Select Status"]) ?>
                    <?= Html::error($model, 'status', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'status')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'is_pagination', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'is_pagination', ['class' => 'input-group-text']); ?>
                    <?= Html::activeDropDownList($model, 'is_pagination', Constants::LABEL_YESNO, ['class' => 'form-select form-select-solid', 'prompt' => "Select is pagination available"]) ?>
                    <?= Html::error($model, 'is_pagination', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'is_pagination')->end() ?>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <h6 class="br-section-label p-4">Url Query Params</h6>
            <?= $this->render("_attributes", ['model' => $model, 'form' => $form, "labelfor" => "api_params"]) ?>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <h6 class="br-section-label p-4">API Payload</h6>
            <?= $this->render("_attributes", ['model' => $model, 'form' => $form, "labelfor" => "api_body"]) ?>
        </div>
        <div class="col-lg-6 col-sm-6 col-xs-6">
            <h6 class="br-section-label p-4">API Specific Headers</h6>
            <?= $this->render("_attributes", ['model' => $model, 'form' => $form, "labelfor" => "api_headers"]) ?>
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