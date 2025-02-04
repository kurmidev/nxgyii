<?php

use app\component\CtGridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use app\component\Constants;
use app\component\Utils;
use app\models\Company;
use app\models\Designation;
use app\models\Employee;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $searchModel common\models\search\CitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Employee';
$this->params['links'] = [
    ['title' => 'Add New Employee', 'url' => \Yii::$app->urlManager->createUrl('employee/add-employee'), 'class' => 'fa fa-plus'],
];
$this->params['breadcrumbs'][] = $this->title;
?>
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
            'email',
            "mobile_no",
            "phone_no",
            [
                'attribute' => 'company_id',
                'label' => 'Company',
                'content' => function ($model) {
                    return !empty($model->company) ? $model->company->name : '';
                },
                'filter' => ArrayHelper::map(Company::find()->all(), "id", "name"),
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
            'actionOn',
            'actionBy',
            [
                'label' => 'Action',
                'content' => function ($data) {
                    return Html::a(Html::tag('span', '', ['class' => 'fa fa-edit']), \Yii::$app->urlManager->createUrl(['designation/update-designation', 'id' => $data['id']]), ['title' => 'Update ' . $data['name'], 'class' => 'btn btn-primary-alt']);
                }
            ]
        ],
    ]);
?>
<?php Pjax::end(); ?>