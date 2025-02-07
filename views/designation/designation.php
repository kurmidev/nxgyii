<?php

use app\component\CtGridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use app\component\Constants;
use app\component\Utils;
use app\models\Designation;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Designation';
$this->params['links'] = [
    ['title' => 'Add New Designation', 'url' => \Yii::$app->urlManager->createUrl('designation/add-designation'), 'class' => 'fa fa-plus'],
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
                'code',
                [
                    'attribute' => 'parent_id',
                    'label' => 'Parent Designation',
                    'content' => function ($model) {
                            return !empty($model->parent) ? $model->parent->name : null;
                        },
                    'filter' => \yii\helpers\ArrayHelper::map(Designation::find()->excludeSysDef()->active()->asArray()->all(), 'id', 'name'),
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
                            return Html::a(Html::tag('i', ' <span class="path1"></span><span class="path2"></span><span class="path3"></span>', ['class' => 'ki-duotone ki-pencil fs-2 ']), \Yii::$app->urlManager->createUrl(['designation/update-designation', 'id' => $data['id']]), ['title' => 'Update ' . $data['name'], 'class' => 'btn btn-primary-alt']);
                        }
                ]
            ],
        ]);
    ?>
    <?php Pjax::end(); ?>
</div>