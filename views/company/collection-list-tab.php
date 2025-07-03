<?php

use app\component\CtGridView;
use yii\helpers\Html;
use app\component\Utils;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = $title;

$this->params['links'][] = ['title' => '← Back', 'url' => "javascript:history.back()", 'class' => 'btn btn-primary'];

$this->params['breadcrumbs'][] = $this->title;

$header = $body = [];
$i = 1;
foreach ($dataProvider as $dataField => $dataValues) {
    $header[] = Html::tag(
        "li",
        Html::tag("a", Utils::convertToHeaderCase($dataField), ["class" => "nav-item " . ($i == 1 ? "active" : ''), "href" => "#kt_tab_pane_$i"]),
        ["class" => "nav-item"]
    );

    $body[] = Html::tag(
        "div",
        CtGridView::widget([
            'dataProvider' => $dataValues,
            'filterModel' => $searchModel,
            'columns' => $columns
        ]),
        ["class" => "tab-pane fade " . ($i == 1 ? "show active" : ''), "role" => "tabpanel", "id" => "kt_tab_pane_$i"]
    );
    $i++;
}


$tabHead = Html::tag("ul", implode("", $header), ["class" => "nav nav-tabs nav-line-tabs mb-5 fs-6"]);
$tabBody = Html::tag("div", implode("", $body), ["class" => "tab-content", "id" => "myTabContent"]);


?>
<div class="card card-flush">
    <?= $this->render('@app/views/layouts/_contentheader', ['title' => $title]) ?>
    <?= $tabHead ?>
    <?= $tabBody ?>
</div>