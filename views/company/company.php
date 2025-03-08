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
    ['title' => 'Add New Company', 'url' => \Yii::$app->urlManager->createUrl('company/add-company'), 'class' => 'btn btn-primary'],
];
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
                'actionOn',
                'actionBy',
                [
                    'label' => 'Action',
                    'content' => function ($data) {
                        $cont = "";
                            $productIds = $data['Product_mappings'];
                            $products = ProductMaster::find()->where(['id' => $productIds])->all();
                                foreach($products as $p){
                                    $cont.='<div class="menu-item px-3">
                                            <a href="'.Yii::$app->urlManager->createUrl(['company/view-company', 'id' => $data['id']]).'" class="menu-link px-3" data-kt-inbox-listing-filter="show_all">
                                            '.$p->name.'
                                        </a>
                                    </div>';
                                }
                            
                        
                            return Html::a(Html::tag('i', ' <span class="path1"></span><span class="path2"></span><span class="path3"></span>', ['class' => 'ki-duotone ki-pencil fs-2 ']), \Yii::$app->urlManager->createUrl(['company/update-company', 'id' => $data['id']]), ['title' => 'Update ' . $data['name'], 'class' => 'btn btn-primary-alt'])
                                .'<div>
                                    <a href="#" class="btn btn-sm btn-icon btn-light btn-active-light-primary" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-start">
                                    <i class="ki-duotone ki-down fs-2"></i>        </a>
                                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                            '.$cont.'
                                        </div>
                                     </div>';

                        }
                ]
            ],
        ]);
    ?>
    <?php Pjax::end(); ?>
</div>