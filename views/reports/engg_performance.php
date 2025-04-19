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

<?= $this->render('@app/views/layouts/_contentheader') ?>
<?= $this->render('@app/views/layouts/_advanceSearch', ['search' => $search, 'model' => $searchModel]) ?>

<?=

CtGridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'engineer_name:Text:Name',
            'total_tickets:Text:Total Tickets',
            'resolved_tickets:Text:Resolved Tickets',
            'avg_rating:Text:Avg Rating',
            'avg_resolution_time:Text:Avg Resolution Time',
            'total_comments:Text:Total Comments',
        ],
    ]);
?>