<?php

use app\component\Constants;
use app\models\Designation;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;


/* @var $this yii\web\View */
/* @var $model common\models\Area */
/* @var $form yii\widgets\ActiveForm */

$this->title = ($model->isNewRecord) ? 'Add new Designation' : 'Update Designation ' . $model->name . ' details.';
$this->params['breadcrumbs'][] = ['label' => 'Designation', 'url' => ['designation']];
$this->params['breadcrumbs'][] = $this->title;

?>
<?= $this->render('@app/views/layouts/_contentheader') ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body">
        <?php $form = ActiveForm::begin(['id' => 'form-designation', 'options' => ['enctype' => 'mutipart/form-data', 'class' => 'form-horizontal form-bordered']]); ?>

        <div class="row">
            <div class="col-lg-4 col-sm-4 col-xs-12">
                <?= $form->field($model, 'name', ['options' => ['class' => 'form-group']])->begin() ?>
                <?= Html::activeLabel($model, 'name', ['class' => 'col-lg-6 col-sm-6 col-xs-6 control-label']); ?>
                <div class="col-lg-6 col-sm-4 col-xs-6">
                    <?= Html::activeTextInput($model, 'name', ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'name', ['class' => 'error help-block']) ?>
                </div>
                <?= $form->field($model, 'name')->end() ?>        
            </div>
            <div class="col-lg-4 col-sm-4 col-xs-12">
                <?= $form->field($model, 'parent_id', ['options' => ['class' => "form-group"]])->begin(); ?>
                <?= Html::activeLabel($model, 'parent_id', ['class' => 'col-lg-6 col-sm-6 col-xs-6 control-label']) ?>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?php
                    $query = Designation::find()->where(["status" => Constants::STATUS_ACTIVE]);
                    if (!empty($model->parent_id)) {
                        $query->andWhere(['not', ['id' => $model->id]]);
                    }
                    $list = ArrayHelper::map($query->all(), 'id', 'name');
                    ?>
                    <?= Html::activeDropDownList($model, 'parent_id', $list, ['class' => 'form-control', 'prompt' => "Select Parent"]) ?>
                    <?= Html::error($model, 'parent_id', ['class' => 'error help-block']) ?>
                </div>
                <?= $form->field($model, 'parent_id')->end() ?>

            </div>
            <div class="col-lg-4 col-sm-6 col-xs-12">


                <?= $form->field($model, 'status', ['options' => ['class' => "form-group"]])->begin(); ?>
                <?= Html::activeLabel($model, 'status', ['class' => 'col-lg-6 col-sm-6 col-xs-6 control-label']) ?>
                <div class="col-lg-6 col-sm-6 col-xs-6">
                    <?php
                    $model->status = isset($model->status) ? $model->status + 0 : "";
                    ?>
                    <?= Html::activeDropDownList($model, 'status', Constants::LABEL_STATUS, ['class' => 'form-control']) ?>
                    <?= Html::error($model, 'status', ['class' => 'error help-block']) ?>
                </div>
                <?= $form->field($model, 'status')->end() ?>

            </div>
        </div>
        <?= $this->render('_access_right', ['menu' => $menu,'savedMenu'=>$savedMenu]) ?>

        <div class="card-footer mg-t-auto">
            <div class="row">
                <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                    <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
