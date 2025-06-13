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
                    <?= Html::activeDropDownList($model, 'display_type', Constants::DISPLAY_LABEL, ['class' => 'form-select form-select-solid', 'prompt' => "Select one", "id" => "display_type"]) ?>
                    <?= Html::error($model, 'display_type', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'display_type')->end() ?>
                </div>
                <div class="col-lg-12 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'api_id', ['options' => ['class' => 'input-group mb-5']])->begin() ?>
                    <?= Html::activeLabel($model, 'api_id', ['class' => 'input-group-text', 'label' => "API List"]); ?>
                    <?= Html::activeDropDownList($model, 'api_id', $assignedApiList, ['class' => 'form-control form-control-solid', 'prompt' => "select one", "id" => "api_id_list"]) ?>
                    <?= Html::error($model, 'api_id', ['class' => 'error help-block text-danger col-lg-12 col-sm-12 col-xs-12 mb-2 mt-2']) ?>
                    <?= $form->field($model, 'api_id')->end() ?>
                </div>

                <div class="col-lg-6 col-sm-6 col-xs-6" id="columns-container">

                </div>
                <div class="col-lg-6 col-sm-6 col-xs-6" id="filter-container">

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
<?php

//javascript function on change of api_id_list call the ajax for fetching the api data 
$url = Yii::$app->urlManager->createUrl(["/company/get-api-data", "id" => ""]);
$javascript = <<<JS
    $(document).ready(function(){
        $("#api_id_list").change(function(){
          getChangeElements();
        });
        $("#display_type").change(function(){
           getChangeElements();
        });
    });

     function getChangeElements(){
          let html1 = '<h4>Select Operation on Column</h4>';
            let html2 = '<h4>Select filter on Column</h4>';
            let api_id = $("#api_id_list").val();
            $.ajax({
                url: '{$url}'+api_id,
                type: "get",
                data: {},
                success: function(response){      
                    let displayType = $("#display_type").val();
                    
                    let options = response.map(f=>"<option value='"+f.key+"'>"+f.key+"</option>");
                    
                    response.forEach(function(column) {
        html1 = "";
        if(Number(displayType)===7){
html1 = `<div class="row mb-2">
    <div class="col-lg-6 col-sm-6 col-xs-6"><label class="form-label">Category</label></div>
    <div class="col-lg-6 col-sm-6 col-xs-6">
        <select id="componentmodel-display_columns-label" class="form-control form-control-solid"  name="ComponentModel[display_columns][label]">
                    `+options+`
        </select>
    </div>
</div>
<div class="row mb-2">
    <div class="col-lg-6 col-sm-6 col-xs-6"><label class="form-label">Values</label></div>
    <div class="col-lg-6 col-sm-6 col-xs-6">
        <select id="componentmodel-display_columns-values" class="form-control form-control-solid" multiple=true name="ComponentModel[display_columns][values][]">
           `+options+`
        </select>
    </div>
</div>
`;
        }else
        if(Number(displayType)===1){
html1=`<div class="row mb-2">
    <div class="col-lg-6 col-sm-6 col-xs-6"><label class="form-label">Fields List</label></div>
    <div class="col-lg-6 col-sm-6 col-xs-6">
        <select id="componentmodel-display_columns-label" class="form-control form-control-solid" multiple=true name="ComponentModel[display_columns][values][]">
            `+options+`
        </select>
    </div>
</div>
</div>`;
                        }else{
                        html1 = `<div class="row mb-2">
    <div class="col-lg-6 col-sm-6 col-xs-6"><label class="form-label">Category</label></div>
    <div class="col-lg-6 col-sm-6 col-xs-6">
        <select id="componentmodel-display_columns-label" class="form-control form-control-solid"  name="ComponentModel[display_columns][label]">
                    `+options+`
        </select>
    </div>
</div>
<div class="row mb-2">
    <div class="col-lg-6 col-sm-6 col-xs-6"><label class="form-label">Values</label></div>
    <div class="col-lg-6 col-sm-6 col-xs-6">
        <select id="componentmodel-display_columns-values" class="form-control form-control-solid" name="ComponentModel[display_columns][values][]">
           `+options+`
        </select>
    </div>
</div>
<div class="row mb-2">
    <div class="col-lg-6 col-sm-6 col-xs-6"><label class="form-label">Actions</label></div>
    <div class="col-lg-6 col-sm-6 col-xs-6">
        <select id="componentmodel-display_columns-action" class="form-control form-control-solid" name="ComponentModel[display_columns][action]">
            <option value="">select one</option>
            <option value="max">Max</option>
            <option value="min">Min</option>
            <option value="sum">SUM</option>
            <option value="avg">AVG</option>
            <option value="count" selected="">COUNT</option>
        </select>
    </div>
</div>`;
            }
                        html2 += '<div class="row">'+
                                    '<div class="col-lg-4 col-sm-4 col-xs-4"><label>' + column.key + '</label></div>'+
                                    '<div class="col-lg-4 col-sm-4 col-xs-4">'+
                                        '<select class="form-control column-operation" name="ComponentModel[filters][' + column.key + '][attr]">' +
                                            '<option value="">Select</option>' +
                                            '<option value="gt">></option>' +
                                            '<option value="eq">==</option>' +
                                            '<option value="lt"><</option>' +
                                            '<option value="gte">>=</option>' +
                                            '<option value="lte"><=</option>' +
                                            '<option value="in">in</option>' +
                                            '<option value="not in">not in</option>' +
                                        '</select>' +
                                    '</div>' +
                                    '<div class="col-lg-4 col-sm-4 col-xs-4">';
                        if(column.values.length>0){
                            html2 +=  '<select class="form-select form-select-solid" multiple=true name="ComponentModel[filters][' + column.key + '][val]">';
                            column.values.forEach(function(value) {
                                html2 += '<option value="'+value+'">'+value+'</option>';
                            });
                            html2 += '</select>';
                        }else{
                            html2 += '<input type="text" class="form-control" name="ComponentModel[filters][' + column.key + '][val]">'
                        }
                        html2 +=  '</div>'+
                                '</div>';
                    });
                    $('#columns-container').html(html1);
                    $('#filter-container').html(html2);
                }
            });
    }
JS;

$this->registerJs($javascript, \yii\web\View::POS_END);