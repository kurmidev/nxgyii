<?php
use app\component\Constants;
use app\models\ProductsApiList;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = "Product Company Mapping";
$this->params['breadcrumbs'][] = ['label' => 'Company', 'url' => ['Company']];
$this->params['breadcrumbs'][] = $this->title;

$apiList = ArrayHelper::index(ProductsApiList::find()->active()->asArray()->all(),'id','product_id');

?>
<?= $this->render('@app/views/layouts/_contentheader') ?>
<?php $form = ActiveForm::begin(['id' => 'form-api-mapping', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'row g-3']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body row g-3">
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <div class="row">
                <?php
                foreach ($products as $product) { ?>
                    <div class="row">
                        <h2 class="br-section-label p-4"> <?= ucwords($product->name) ?></h2>
                        <h6 class="br-section-label p-4">Credentials/Tokens</h6>
                        <?php if ($product->authentication_type == Constants::AUTH_TYPE_LOGIN) { ?>

                            <div class="col-lg-6 col-sm-6 col-xs-6">
                                <?= $form->field($model, 'credentials[' . $product->id . '][username]', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                                <?= Html::activeLabel($model, 'credentials[' . $product->id . '][username]', ['class' => 'input-group-text', 'label' => "Username"]); ?>
                                <?= Html::activeTextInput($model, 'credentials[' . $product->id . '][username]', ['class' => 'form-control form-control-solid']) ?>
                                <?= Html::error($model, 'credentials[' . $product->id . '][username]', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                                <?= $form->field($model, 'credentials[' . $product->id . '][username]')->end() ?>
                            </div>
                            <div class="col-lg-6 col-sm-6 col-xs-6">
                                <?= $form->field($model, 'credentials[' . $product->id . '][password]', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                                <?= Html::activeLabel($model, 'credentials[' . $product->id . '][password]', ['class' => ' input-group-text', 'label' => "Password"]); ?>
                                <?= Html::activeTextInput($model, 'credentials[' . $product->id . '][password]', ['class' => 'form-control form-control-solid']) ?>
                                <?= Html::error($model, 'credentials[' . $product->id . '][password]', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                                <?= $form->field($model, 'credentials[' . $product->id . '][password]')->end() ?>
                            </div>

                        <?php } else if ($product->authentication_type == Constants::AUTH_TYPE_TOKEN) { ?>

                                <div class="col-lg-6 col-sm-6 col-xs-6">
                                <?= $form->field($model, 'credentials[' . $product->id . '][token]', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                                <?= Html::activeLabel($model, 'credentials[' . $product->id . '][token]', ['class' => ' input-group-text', 'label' => 'Token']); ?>
                                <?= Html::activeTextInput($model, 'credentials[' . $product->id . '][token]', ['class' => 'form-control form-control-solid']) ?>
                                <?= Html::error($model, 'credentials[' . $product->id . '][token]', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                                <?= $form->field($model, 'credentials[' . $product->id . '][token]')->end() ?>
                                </div>
                        <?php } ?>

                        <div class="col-lg-6 col-sm-6 col-xs-6">
                            <?= $form->field($model, 'allowed_api[' . $product->id . ']', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                            <?= Html::activeLabel($model, 'allowed_api[' . $product->id . ']', ['class' => ' input-group-text', 'label' => 'Allowed APIs']); ?>
                            <div class="col-lg-6 col-sm-6 col-xs-6">
                            <?= Html::activeDropDownList($model, 'allowed_api[' . $product->id . ']',
                            ArrayHelper::map(!empty($apiList[$product->id])?$apiList[$product->id]:[],'id','api_name') 
                            ,['class' => 'form-control form-select-solid', 'prompt' => "Select one", "multiple" => "multiple", "data-control" => "select2","style"=>"width:auto;"]) ?>
                            </div>
                            <?= Html::error($model, 'allowed_api[' . $product->id . ']', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                            <?= $form->field($model, 'allowed_api[' . $product->id . ']')->end() ?>
                        </div>


                        <h6 class="br-section-label p-4">Login Headers</h6>
                        <?= $this->render("_attributes", ['model' => $model, 'form' => $form, "product_id" => $product->id, "labelfor" => "headers"]) ?>
                    </div>
                <?php } ?>
            </div>
        </div>
        <div class="row mt-5">
            <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                <?= Html::submitButton("Save Mapping", ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>