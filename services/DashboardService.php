<?php

namespace app\services;

use app\models\ProductMaster;
use app\component\Constants as C;
use yii\helpers\ArrayHelper;

class DashboardService
{
    private $dashboardObj;
    private $dashboardType;

    public function __construct($product_id)
    {
        $product = ProductMaster::findOne(['id' => $product_id]);
        if ($product instanceof ProductMaster) {
            $attr = !empty($product->productAttributes) ? ArrayHelper::map($product->productAttributes, 'attr_type', 'attr_value', 'attr_for') : [];
            $this->dashboardType = $product->service_provider;
            switch ($product->service_provider) {
                case C::JUMPCLOUD:
                    $this->dashboardObj = new JumpCloudService($attr);
                    break;
                case C::SECEON:
                    $this->dashboardObj = new SeceonService($attr);
                    break;
                default:
                    //$this->dashboardObj = new DefaultService();
                    break;
            }
        }

    }

    public function getDashboardTypes(){
        return $this->dashboardType;
    }


    public function getDashboardCounts(): array
    {
        return $this->dashboardObj->getDashboardCounts();
    }

    public function getData($request): array
    {
        return $this->dashboardObj->getData($request);
        
    }
}

