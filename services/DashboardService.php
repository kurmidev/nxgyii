<?php

namespace app\services;

use app\models\ProductMaster;
use app\component\Constants as C;
use yii\helpers\ArrayHelper;

class DashboardService {
    private $dashboardObj;

    public function __construct($product_id){
        $product = ProductMaster::findOne(['id'=>$product_id]);
        if($product instanceof ProductMaster){
            $attr = !empty($product->productAttributes)?ArrayHelper::map($product->productAttributes,'attr_type','attr_value','attr_for'):[];
            switch($product->service_provider){
                case C::JUMPCLOUD:
                    $this->dashboardObj = new JumpCloudService($attr);
                    break;
                default:
                    //$this->dashboardObj = new DefaultService();
                    break;
            }
        }
        
    }

    public function getDashboardCounts(): array{
        return $this->dashboardObj->getDashboardCounts();
    }

    public function getData(string $report, array $filter): array{
        // TODO: Implement getData() method.
        return [];
    }
}

