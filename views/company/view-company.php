<?php
use app\models\Products;


$this->title = "Dashboard for {$model->name}";
$this->params['links'] = [
    ['title' => 'Add Dashboard Component', 'url' => \Yii::$app->urlManager->createUrl(['company/add-component','id'=>$model->id]), 'class' => 'btn btn-primary'],
];
$this->params['breadcrumbs'][] = $this->title;

$assignedProduct = Products::find()->active()->andWhere(['id' => $model->getProduct_mappings()])->all();


?>
<div class="card card-flush">
    <?= $this->render('@app/views/layouts/_contentheader') ?>
    <div class="card-header">
        <ul class="nav nav-tabs nav-line-tabs mb-5 fs-6">
            <li class="nav-item">
                <a class="nav-link active"
                    href="<?= Yii::$app->urlManager->createUrl(["company/view-company", "dash" => 0, "id" => $model->id]) ?>">Main
                    Dashboard</a>
            </li>
            <?php foreach ($assignedProduct as $product) { ?>
                <li class="nav-item">
                    <a class="nav-link"
                        href="<?= Yii::$app->urlManager->createUrl(["company/view-company", "dash" => $product->id, "id" => $model->id]) ?>"><?= $product->name ?></a>
                </li>
            <?php } ?>
        </ul>
    </div>
    <div class="card-body pt-0 tab-content">
        <div class="tab-pane fade show active" id="kt_tab_pane_7" role="tabpanel">
            .......................
        </div>
    </div>
</div>