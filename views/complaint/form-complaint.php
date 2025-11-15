<?php

use app\component\Constants;
use app\models\Categories;
use app\models\Company;
use app\models\User;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'Raise New Complaint';
$this->params['breadcrumbs'][] = ['label' => 'Complaint', 'url' => ['Complaint']];
$this->params['breadcrumbs'][] = $this->title;

$catgory = ArrayHelper::map(Categories::find()->where(['status' => Constants::STATUS_ACTIVE])->andWhere([">", "parent_id", 0])->all(), 'id', 'name');

$user = User::currentUser();
$company = ArrayHelper::map(Company::find()->active()->defaultCondition()->all(), 'id', 'name');
?>
<?= $this->render('@app/views/layouts/_contentheader') ?>
<?php $form = ActiveForm::begin(['id' => 'form-complaint', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'row g-3']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body row g-3">
        <div class="col-md-12">
            <?= $form->field($model, 'subject', ['options' => ['class' => 'form-group ']])->begin() ?>
            <?= Html::activeLabel($model, 'subject', ['class' => ' control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeTextInput($model, 'subject', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'subject', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'subject')->end() ?>
        </div>
        <div class="col-md-12">
            <?= $form->field($model, 'description', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'description', ['class' => ' control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeTextarea($model, 'description', ['class' => 'form-control']) ?>
                <?= Html::error($model, 'description', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'description')->end() ?>
        </div>
        <?php if($user->user_type!=Constants::USERTYPE_CLIENT){ ?>
            <div class="col-md-12">
            <?= $form->field($model, 'company_id', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'company_id', ['class' => ' control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeDropDownList($model, 'company_id', $company, ['class' => 'form-control','prompt' => 'Select Company']) ?>
                <?= Html::error($model, 'company_id', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'company_id')->end() ?>
        </div>
        <?php } ?>

        <div class="col-md-6">
            <?= $form->field($model, 'priority', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'priority', ['class' => ' control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeDropDownList($model, 'priority', Constants::LABEL_PRIORITY, ['class' => 'form-control', 'maxlength' => 10]) ?>
                <?= Html::error($model, 'priority', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'priority')->end() ?>
        </div>
        <div class="col-md-6">
            <?= $form->field($model, 'sub_category_id', ['options' => ['class' => 'form-group']])->begin() ?>
            <?= Html::activeLabel($model, 'sub_category_id', ['class' => ' control-label']); ?>
            <div class="col-lg-6 col-sm-6 col-xs-6">
                <?= Html::activeDropDownList($model, 'sub_category_id', $catgory,['class' => 'form-control','prompt'=>"Select  Category"]) ?>
                <?= Html::error($model, 'sub_category_id', ['class' => 'error help-block']) ?>
            </div>
            <?= $form->field($model, 'sub_category_id')->end() ?>
        </div>

        <div class="row mt-5">
            <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>