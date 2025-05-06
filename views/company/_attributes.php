<?php

use yii\helpers\Html;
?>
<div class="dynamic-listing-group">
    <div class="input-group input-group-solid mb-5">
        <input type="text" class="form-control form-control-solid" placeholder="Key" aria-label="Key" value="Key"
            readonly="true" />
        <span class="input-group-text">=</span>
        <input type="text" class="form-control form-control-solid" placeholder="Value" aria-label="Value" value="Value"
            readonly="true" />
    </div>


    <?php
    $count = !empty($model->$labelfor) ? count($model->$labelfor) : 1;

    for ($i = 0; $i < $count; $i++) { ?>
        <div class="col-lg-12 col-sm-12 col-xs-12">
            <?php
            $keyErrorLabel = "{$labelfor}[$product_id][$i][key]";
            $valErrorLabel = "{$labelfor}[$product_id][$i][val]";
            ?>
            <?= $form->field($model, $labelfor . '['.$product_id.'][' . $i . '][key]', ['options' => ['class' => 'input-group input-group-solid mb-5']])->begin() ?>
            <?= Html::activeTextInput($model, $keyErrorLabel, ['class' => 'form-control form-control-solid', "value" => !empty($model->$labelfor[$product_id][$i]['key']) ? $model->$labelfor[$product_id][$i]['key'] : ""]) ?>
            <span class="input-group-text">=</span>
            <?= Html::activeTextInput($model, $valErrorLabel, ['class' => 'form-control form-control-solid', "value" => !empty($model->$labelfor[$product_id][$i]['val']) ? $model->$labelfor[$product_id][$i]['val'] : ""]) ?>
            <?php
            if ($i == 0) {
                echo Html::tag('span', '', ['class' => 'fa fa-plus btn btn-success btn-xs dynamic-listing']);
            } else {
                echo Html::tag('span', '', ['class' => 'fa fa-minus btn btn-danger btn-xs', "onclick" => "$(this).parentElement.parentElement.remove();"]);
            }
            ?>
            <?= $form->field($model, $labelfor . '[key][' . $i . ']')->end() ?>
        </div>
        <?php
    } ?>
</div>