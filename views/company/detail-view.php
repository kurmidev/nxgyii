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
$this->title = 'Company';
$this->params['links'] = [
];
$this->params['breadcrumbs'][] = $title;
?>

<div class="card card-flush">
    <?= $this->render('@app/views/layouts/_contentheader') ?>
    <?php Pjax::begin(); ?>
    <?=CtGridView::widget([
            'dataProvider' => $dataProvider,
          //'filterModel' => $searchModel,
            'columns' => $columns
        ]);
    ?>
    <?php Pjax::end(); ?>
</div>