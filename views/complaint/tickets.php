<?php

use yii\helpers\Html;
use common\component\ImsGridView;
use yii\widgets\Pjax;
use app\component\Constants;
use app\component\CtGridView;
use app\component\Utils;
use app\models\Company;
use app\models\ProductMaster;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Complaints';
$this->params['links'] = [
    ['title' => 'Add New Complaints', 'url' => \Yii::$app->urlManager->createUrl('complaint/add-complaint'), 'class' => 'btn btn-primary'],
];
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="card card-flush">
    <?= $this->render('@app/views/layouts/_contentheader') ?>
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
                'subject',
                [
                    'attribute' => 'priority',
                    'label' => 'Priority',
                    'content' => function ($model) {
                            return Utils::getLabels(Constants::LABEL_PRIORITY, $model->priority);
                        },
                    'filter' => Constants::LABEL_PRIORITY,
                ],
                'category.name:text:Category',
                'subCategory.name:text:Sub Category',
                'start_date',
                [
                    'attribute' => 'status',
                    'label' => 'Status',
                    'content' => function ($model) {
                            return Utils::getLabels(Constants::LABEL_COMPLAINT_STATUS, $model->status);
                        },
                    'filter' => Constants::LABEL_COMPLAINT_STATUS,
                ],
                [
                    'attribute' => 'priority',
                    'label' => 'Priority',
                    'content' => function ($model) {
                            return Utils::getLabels(Constants::LABEL_PRIORITY, $model->priority);
                        },
                    'filter' => Constants::LABEL_PRIORITY,
                ],
                [
                    'label' => 'Action',
                    'content' => function ($data) {
                            $content = [
                                ["name" => "Reply/View", "url" => \Yii::$app->urlManager->createUrl(['complaint/process-complaint', "id" => $data->id])],
                            ];
                            if ($data->status != Constants::CLOSED) {
                                $content[] = ["name" => "Close", "url" => \Yii::$app->urlManager->createUrl(['complaint/close-complaint', "id" => $data->id])];
                            }
                            return Utils::getDropDownButton($content);
                        }
                ]
            ],
        ]);
    ?>
    <?php Pjax::end(); ?>
</div>