<?php

use app\component\Constants;
use app\component\Utils;
use app\models\Products;
use app\models\User;
use app\component\widgets\BarChartWidget;
use app\component\widgets\PiesChartWidget;
use app\component\widgets\LineChartWidget;
use app\component\widgets\XYBubbleChartWidget;


$this->title = "Dashboard for {$model->name}";
$this->params['links'] = [];
if (Utils::isallowed("company-add-component")) {
    $this->params['links'][] = ['title' => 'Add Dashboard Component', 'url' => \Yii::$app->urlManager->createUrl(['company/add-component', 'id' => $model->id]), 'class' => 'btn btn-primary'];
}


$this->params['breadcrumbs'][] = $this->title;

$assignedProduct = Products::find()->active()->andWhere(['id' => $model->getProduct_mappings()])->all();
?>
<div class="card card-flush">
    <?= $this->render('@app/views/layouts/_contentheader') ?>
    <div class="card-header">
        <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
            <li class="nav-item">
                <a class="nav-link <?= $dash == 0 ? 'active' : '' ?>"
                    href="<?= Yii::$app->urlManager->createUrl(["company/view-company", "dash" => 0, "id" => $model->id]) ?>">Main
                    Dashboard</a>
            </li>
            <?php foreach ($assignedProduct as $product) { ?>
                <li class="nav-item">
                    <a class="nav-link  <?= $dash == $product->id ? 'active' : '' ?>"
                        href="<?= Yii::$app->urlManager->createUrl(["company/view-company", "dash" => $product->id, "id" => $model->id]) ?>"><?= ucwords($product->name) ?></a>
                </li>
            <?php } ?>

            <?php if (User::loggedInUserType() != Constants::USERTYPE_CLIENT && Utils::isallowed("company-add-component")) { ?>
                <li class="nav-item">
                    <a class="nav-link  <?= $dash == -1 ? 'active' : '' ?>"
                        href="<?= Yii::$app->urlManager->createUrl(["company/view-company", "dash" => -1, "id" => $model->id]) ?>">Component
                        List</a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="card-body pt-0 tab-content">
        <div class="tab-pane fade show active" id="kt_tab_pane_7" role="tabpanel">
            <?php if ($dash == -1) { ?>
                <?= $this->render('@app/views/company/component-list', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider
                ]) ?>
            <?php } else { ?>
                <?php if ($dash == Constants::PRODUCT_ID_JUMPCLOUD) { ?>
                    <div class="d-flex flex-row flex-end gap-5">
                        <!-- move button to right -->
                        <a class="btn btn-danger fw-semibold" href="https://console.jumpcloud.com/login/admin"
                            target="_blank">JUMPCLOUD</a>
                        <!-- move button to right -->
                        <a class="btn btn-danger fw-semibold"
                            href="<?= Yii::$app->urlManager->createUrl(["company/alerts"]) ?>">Alerts</a>
                        <!-- move button to right -->
                        <a class="btn btn-danger fw-semibold"
                            href="<?= Yii::$app->urlManager->createUrl(["company/insights"]) ?>">Insights</a>
                    </div>
                <?php } ?>
                <div id="kt_app_content_container" class="app-container row container-fluid ">
                    <?php foreach ($graph as $graphItem) { ?>
                        <?= $graphItem ?>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<?php
$this->registerJsFile("https://cdn.amcharts.com/lib/5/index.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://cdn.amcharts.com/lib/5/xy.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://cdn.amcharts.com/lib/5/percent.js", ['position' => \yii\web\View::POS_HEAD]);
$this->registerJsFile("https://cdn.amcharts.com/lib/5/themes/Animated.js", ['position' => \yii\web\View::POS_HEAD]);