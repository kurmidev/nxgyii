<?php

use app\component\Constants;
use app\models\ProductsApiList;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$assignedApiList = ArrayHelper::map(
    ProductsApiList::find()->where(['id' => $company->assignedApiList])->active()->all(),
    "id",
    "api_name"
);

?>
<?= $this->render('@app/views/layouts/_contentheader') ?>
<?php $form = ActiveForm::begin(['id' => 'form-api-mapping', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'row g-3']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body row g-3">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'report_name', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'report_name', ['class' => 'input-group-text']); ?>
                    <?= Html::activeTextInput($model, 'report_name', ['class' => 'form-control form-control-solid']) ?>
                    <?= Html::error($model, 'report_name', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'report_name')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'description', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'description', ['class' => 'input-group-text']); ?>
                    <?= Html::activeTextInput($model, 'description', ['class' => 'form-control form-control-solid']) ?>
                    <?= Html::error($model, 'description', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'description')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'on_main_dashboard', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'on_main_dashboard', ['class' => 'input-group-text']); ?>
                    <?= Html::activeDropDownList($model, 'on_main_dashboard', Constants::LABEL_YESNO, ['class' => 'form-control form-control-solid', 'prompt' => "select one"]) ?>
                    <?= Html::error($model, 'on_main_dashboard', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'on_main_dashboard')->end() ?>
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?= $form->field($model, 'display_type', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'display_type', ['class' => 'input-group-text']); ?>
                    <?= Html::activeDropDownList($model, 'display_type', Constants::DISPLAY_LABEL, ['class' => 'form-select form-select-solid', 'prompt' => "Select one"]) ?>
                    <?= Html::error($model, 'display_type', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'display_type')->end() ?>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'api_id', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'api_id', ['class' => 'input-group-text', 'label' => "API List"]); ?>
                    <?= Html::activeDropDownList($model, 'api_id', $assignedApiList, ['class' => 'form-control form-control-solid', 'readonly' => true,"disabled"=>true]) ?>
                    <?= Html::error($model, 'api_id', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'api_id')->end() ?>
                </div>

                <div class="col-lg-6 col-sm-6 col-xs-6" id="columns-container">
                <h4>Select Operation on Column</h4>
                <?=$this->render('_operator_column', ['model' => $model,'apiData'=>$apiData])?>
                    
                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6" id="filter-container">
                <h4>Select filter on Column</h4>
                    <?php foreach ($apiData as $api) { ?>
                        <div class="row">
                            <div class="col-lg-4 col-sm-4 col-xs-4">
                                <label><?= $api["key"] ?></label>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-xs-4">
                                <?= Html::activeDropDownList($model, 'filters[' . $api["key"] . '][attr]', [
                                    'gt' => '>',
                                    'eq' => '==',
                                    'lt' => '<',
                                    'gte' => '>=',
                                    'lte' => '<=',
                                    'neq' => '!=',
                                    "in" => 'in',
                                    "not in" => 'not in',
                                ], ['class' => 'form-control form-control-solid', 'prompt' => "select one", "id" => "api_id_list"]) ?>
                            </div>
                            <div class="col-lg-4 col-sm-4 col-xs-4">
                                <?php if (!empty($api["values"])) { ?>
                                    <?= Html::activeDropDownList($model, 'filters[' . $api["key"] . '][val]', $api["values"], ['class' => 'form-control form-control-solid', 'prompt' => "select one", "id" => "api_id_list"]) ?>
                                <?php } else { ?>
                                    <?= Html::activeTextInput($model, 'filters[' . $api["key"] . '][val]', ['class' => 'form-control form-control', "id" => "api_id_list"]) ?>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-5">
        <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
            <?= Html::submitButton("Save Mapping", ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>