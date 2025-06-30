<?php

use app\component\CtGridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use app\component\Constants;
use app\component\Utils;
use app\models\Company;
use app\models\Designation;
use app\models\Employee;
use app\models\ProductMaster;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Employee';
$this->params['links'] = [
];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-flush">
    <?= $this->render('@app/views/layouts/_contentheader') ?>
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
                'email',
                "mobile_no",
                "phone_no",
                [
                    'attribute' => 'company_id',
                    'label' => 'Company',
                    'content' => function ($model) {
                            return !empty($model->company) ? $model->company->name : '';
                        },
                    'filter' => ArrayHelper::map(Company::find()->defaultCondition()->all(), "id", "name"),
                ],
                [
                    'attribute' => 'designation_id',
                    'label' => 'Designation',
                    'content' => function ($model) {
                            return !empty($model->designation) ? $model->designation->name : '';
                        },
                    'filter' => ArrayHelper::map(Designation::find()->all(), "id", "name"),
                ],
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
                            if (Utils::isallowed("company-update-employee")) {
                                $content[] = ["name" => "Edit Employee", "url" => \Yii::$app->urlManager->createUrl(['employee/update-employee', 'id' => $data['id']])];
                            }
                            if (Utils::isallowed("company-change-password")) {
                                $content[] = ["name" => "Change Password", "url" => \Yii::$app->urlManager->createUrl(['employee/change-password', "id" => $data->id])];
                            }
                            if (Utils::isallowed("company-view-company")) {
                                $content[] = ["name" => "Dashboard", "url" => \Yii::$app->urlManager->createUrl(['company/view-company', "employee_id" => $data->id, "id" => $data->company_id])];
                            }
                            return Utils::getDropDownButton($content);
                        }
                ]
            ],
        ]);
    ?>

</div>