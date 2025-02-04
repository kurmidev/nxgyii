<?php

use yii\helpers\Html;

$j = !empty($model->savedAttributes) ? array_keys($model->savedAttributes) : [0];
$sattr = !empty($model->savedAttributes) ? $model->savedAttributes : [];
?>
<table class="table table-striped table-bordered" id="clonetable">
    <thead>
        <tr>
            <th>Name</th>
            <th>Value</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($j as $i) { ?>
            <tr>
                <td>
                    <?= $form->field($model, 'attrib[' . $i . '][attr_type]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeTextInput($model, 'attrib[' . $i . '][attr_type]', ['class' => 'form-control',"value"=>!empty($sattr[$i]['attr_type'])?$sattr[$i]['attr_type']:""]) ?>
                    <?= $form->field($model, 'attrib[' . $i . '][attr_type]')->end() ?>
                </td>
                <td>
                    <?= $form->field($model, 'attrib[' . $i . '][attr_value]', ['options' => ['class' => 'form-group']])->begin() ?>
                    <?= Html::activeTextInput($model, 'attrib[' . $i . '][attr_value]', ['class' => 'form-control',"value"=>!empty($sattr[$i]['attr_value'])?$sattr[$i]['attr_value']:""]) ?>
                    <?= $form->field($model, 'attrib[' . $i . '][attr_value]')->end() ?>
                </td>
                <td>
                    <?php
                    if ($i == 0) {
                        echo Html::tag('span', '', ['class' => 'fa fa-plus btn btn-success btn-xs', 'onclick' => 'addmoretablerow(this)']);
                    } else {
                        echo Html::tag('span', '', ['class' => 'fa fa-minus btn btn-danger btn-xs', "onclick" => "$(this).closest('tr').remove();"]);
                    }
                    ?>        
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>