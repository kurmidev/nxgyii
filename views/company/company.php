<?php

use yii\widgets\Pjax;
use app\component\Constants;
use app\component\CtGridView;
use app\component\Utils;
/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Company';
$this->params['links'] = [];
if (Utils::isallowed("company-add-company")) {
    $this->params['links'][] = ['title' => 'Add New Company', 'url' => \Yii::$app->urlManager->createUrl('company/add-company'), 'class' => 'btn btn-primary'];
};
$this->params['breadcrumbs'][] = $this->title;
?>



<div class="card card-flush">
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
                'mobile_no',
                'phone_no',
                'email',
                'billing_address',
                [
                    'attribute' => 'status',
                    'label' => 'Status',
                    'content' => function ($model) {
                            return Utils::getLabels(Constants::LABEL_STATUS, $model->status);
                        },
                    'filter' => Constants::LABEL_STATUS,
                ],
                [
                    'attribute' => 'added_on',
                    'label' => 'Action On',
                    'content' => function ($model) {
                            return $model->getActionOn();
                        },
                ],
                [
                    'attribute' => 'added_by',
                    'label' => 'Action By',
                    'content' => function ($model) {
                            return $model->getActionBy();
                        },
                ],
                [
                    'label' => 'Action',
                    'attribute' => 'id',
                    'content' => function ($data) {
                            $content = [];
                            if (Utils::isallowed("company-update-company")) {
                                $content[] = ["name" => "Edit Company", "url" => \Yii::$app->urlManager->createUrl(['company/update-company', "id" => $data->id])];
                            }
                            if (Utils::isallowed("company-view-company")) {
                                $content[] = ["name" => "View Company", "url" => \Yii::$app->urlManager->createUrl(['company/view-company', "id" => $data->id])];
                            }
                            if (Utils::isallowed("company-change-password")) {
                                $content[] = ["name" => "Change Password", "url" => \Yii::$app->urlManager->createUrl(['company/change-password', "id" => $data->id])];
                            }
                            if (Utils::isallowed("employee-add-employee")) {
                                $content[] = ["name" => "Add Employee", "url" => \Yii::$app->urlManager->createUrl(['employee/add-employee', "company_id" => $data->id])];
                            }
                            if (Utils::isallowed("company-map-product")) {
                                $content[] = ["name" => "Product Mapping", "url" => \Yii::$app->urlManager->createUrl(['company/map-product', "id" => $data->id])];
                            }
                            if (Utils::isallowed("company-view-company")) {
                                $content[] = ["name" => "Dashboard", "url" => \Yii::$app->urlManager->createUrl(['company/view-company', "id" => $data->id])];
                            }
                            return Utils::getDropDownButton($content);
                        }
                ]
            ],
        ]);
    ?>
    <?php Pjax::end(); ?>
</div>