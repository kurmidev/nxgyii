<?php

use app\component\Constants;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


?>
<?php $form = ActiveForm::begin(['id' => 'form-complaint-rating', 'options' => ['enctype' => 'multipart/form-data', 'class' => 'row g-3']]); ?>
<div class="card bd-0 shadow-base widget-14 ht-100p">
    <div class="card-body row g-3">
        <div class="col-md-12">
            <?= $form->field($model, 'rating', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
            <?= Html::activeLabel($model, 'rating', ['class' => 'input-group-text']); ?>
            <?= Html::activeDropDownList($model, 'rating', Constants::LABEL_RATING, ['class' => 'form-select form-select-solid', 'prompt' => "Rate me"]) ?>
            <?= Html::error($model, 'rating', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
            <?= $form->field($model, 'rating')->end() ?>
        </div>

        <div class="d-flex flex-column">
            <h4 class="anchor fw-bold mb-5">Rating Descriptions</h4>
            <li class="d-flex align-items-center py-2">
                <span class="bullet bullet-line me-5"></span> Unacceptable - significantly below expectations
            </li>
            <li class="d-flex align-items-center py-2">
                <span class="bullet bullet-line bg-danger me-5"></span> Needs Improvement - didn't fully meet
                expectations
            </li>
            <li class="d-flex align-items-center py-2">
                <span class="bullet bullet-line bg-success me-5"></span> Meets Expectations - meets the set criteria
            </li>
            <li class="d-flex align-items-center py-2">
                <span class="bullet bullet-line bg-info me-5"></span> Exceeds Expectations - generally exceeds the
                criteria
            </li>
            <li class="d-flex align-items-center py-2">
                <span class="bullet bullet-line bg-primary me-5"></span> Outstanding - performs significantly above
                expectations
            </li>
        </div>


        <div class="row mt-5">
            <div class="col-lg-6 col-sm-6 col-xs-6 col-sm-offset-3">
                <?= Html::submitButton('Close', ['class' => 'btn btn-primary mt-n0 mb-20 position-relative float-end me-7']) ?>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>