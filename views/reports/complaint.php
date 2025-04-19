<?php

use app\component\Constants;
use app\component\CtGridView;
use app\component\Utils;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>

<?= $this->render('@app/views/layouts/_header') ?>
<?= $this->render('@app/views/layouts/_advanceSearch', ['search' => $search, 'model' => $searchModel]) ?>

<?=

CtGridView::widget([
        'dataProvider' => $dataProvider,
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
            'updated_on:datetime',
        ],
    ]);
?>