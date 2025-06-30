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
$this->title = $title;

$this->params['links'][] = ['title' => '← Back', 'url' => "javascript:history.back()", 'class' => 'btn btn-primary'];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-flush">
    <?= $this->render('@app/views/layouts/_contentheader',['title'=>$title]) ?>
    <?php Pjax::begin(); ?>
    <?=

        CtGridView::widget([
            'dataProvider' => $dataProvider,
            'columns' =>$columns
        ]);
    ?>
    <?php Pjax::end(); ?>
</div>