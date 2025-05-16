<?php

use yii\widgets\Pjax;
use app\component\Constants;
use app\component\CtGridView;
use app\component\Utils;


/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<div class="card card-flush">
    <?php Pjax::begin(); ?>
    <?=

        CtGridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'rowOptions' => function ($model, $index, $widget, $grid) {
                    if ($model->status == Constants::STATUS_INACTIVE) {
                        return ['style' => 'color:#a94442; background-color:#f2dede;'];
                    }
                },
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'report_name',
                'product.name:text:Product',
                'api.api_name:text:API Name',
                [
                    'attribute' => 'display_type',
                    'label' => 'Display Type',
                    'content' => function ($model) {
                            return Utils::getLabels(Constants::DISPLAY_LABEL, $model->display_type);
                        },
                    'filter' => Constants::DISPLAY_LABEL,
                ],
                [
                    'attribute' => 'status',
                    'label' => 'Status',
                    'content' => function ($model) {
                            return Utils::getLabels(Constants::LABEL_STATUS, $model->status);
                        },
                    'filter' => Constants::LABEL_STATUS,
                ],
                'actionOn',
                'actionBy',
                [
                    'label' => 'Action',
                    'content' => function ($data) {
                            $content = [
                                ["name" => "Edit {$data->report_name}", "url" => \Yii::$app->urlManager->createUrl(['company/update-component-list', "company_id"=>$data->company_id,"id" => $data->id])],
                            ];
                            return Utils::getDropDownButton($content);
                        }
                ]
            ],
        ]);
    ?>
    <?php Pjax::end(); ?>
</div>