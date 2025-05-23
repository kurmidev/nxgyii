<?php

use app\component\CtGridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use app\component\Constants;
use app\component\Utils;
use app\models\Designation;
use app\models\ProductMaster;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'User';
$this->params['links'] = [
    ['title' => 'Add New User', 'url' => \Yii::$app->urlManager->createUrl('plugin/add-user'), 'class' => 'fa fa-plus'],
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
                'name',
                'mobile_no',
                'email',
                [
                    'attribute' => 'designation_id',
                    'label' => 'Designation',
                    'content' => function ($model) {
                            return !empty($model->designation)?$model->designation->name:"";
                        },
                    'filter' => ArrayHelper::map(Designation::find()->active()->all(), 'id', 'name'),
                ],
                'last_access_time',
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
                            ["name" => "Edit User" , "url" => \Yii::$app->urlManager->createUrl(['plugin/update-user', "id" => $data->id])],
                            ["name" => "Change Password" , "url" => \Yii::$app->urlManager->createUrl(['plugin/change-password', "id" => $data->id])],
                        ];
                        return Utils::getDropDownButton($content);
                        }
                ]
            ],
        ]);
    ?>
    <?php Pjax::end(); ?>
</div>