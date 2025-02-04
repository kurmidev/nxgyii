<?php

use app\component\CtGridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use app\component\Constants;
use app\component\Utils;
use app\models\ProductMaster;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Product';
$this->params['links'] = [
    ['title' => 'Add New Product', 'url' => \Yii::$app->urlManager->createUrl('product/add-product'), 'class' => 'fa fa-plus'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
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
            'service_provider',
            'description',
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
                    return Html::a(Html::tag('span', '', ['class' => 'fa fa-edit']), \Yii::$app->urlManager->createUrl(['product/update-product', 'id' => $data['id']]), ['title' => 'Update ' . $data['name'], 'class' => 'btn btn-primary-alt']);
                }
            ]
        ],
    ]);
?>
<?php Pjax::end(); ?>