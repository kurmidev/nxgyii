<?php

use app\component\CtGridView;
use app\component\widgets\BarChartWidget;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = $title;

$this->params['links'][] = ['title' => '← Back', 'url' => "javascript:history.back()", 'class' => 'btn btn-primary'];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-flush">
    <?= $this->render('@app/views/layouts/_contentheader', ['title' => $title]) ?>
    <?= BarChartWidget::widget(["reportName" => " Event Frequency", "data" => $gaphData]) ?>

    <?=
        CtGridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => $columns
        ]);
    ?>
</div>