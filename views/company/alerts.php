<?php

use app\component\CtGridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = $title;

$this->params['links'][] = ['title' => '← Back', 'url' => "javascript:history.back()", 'class' => 'btn btn-primary'];

$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-flush">
    <?= $this->render('@app/views/layouts/_contentheader', ['title' => $title]) ?>
    <div class="rounded border p-10">
        <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
            <li class="nav-item" role="presentation">
                <a class="nav-link <?= ($type == "open" ? "active" : "") ?>" 
                    href="<?= Yii::$app->urlManager->createUrl(["company/alerts", "type" => "open"]) ?>">
                    Open (<?=$counts["ALERT_STATUS_OPEN"]?>)
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link <?= ($type == "acknowledged" ? "active" : "") ?>"
                    href="<?= Yii::$app->urlManager->createUrl(["company/alerts", "type" => "acknowledged"]) ?>"
                    role="tab">
                    Acknowledged (<?=$counts["ALERT_STATUS_ACKNOWLEDGED"]?>)
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link <?= ($type == "resolved" ? "active" : "") ?>" 
                    href="<?= Yii::$app->urlManager->createUrl(["company/alerts", "type" => "resolved"]) ?>">
                    Resolved (<?=$counts["ALERT_STATUS_RESOLVED"] + $counts['ALERT_STATUS_AUTO_RESOLVED']?>)
                </a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link <?= ($type == "all" ? "active" : "") ?>" 
                    href="<?= Yii::$app->urlManager->createUrl(["company/alerts", "type" => "all"]) ?>" >
                    All (<?=$counts["ALERT_STATUS_RESOLVED"] + $counts['ALERT_STATUS_AUTO_RESOLVED'] + $counts['ALERT_STATUS_OPEN'] + $counts['ALERT_STATUS_ACKNOWLEDGED']?>)
                </a>
            </li>
        </ul>
        <div class="tab-content">
            <?=
                CtGridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => $columns
                ]);
            ?>
        </div>
    </div>

</div>