<?php
namespace app\models;

use app\component\Constants;
use app\models\Products;
use PHPUnit\TextUI\Configuration\Constant;

class ComponentModel extends \yii\base\Model
{

    public $id;
    public $report_name;
    public $description;
    public $api_id;
    public $display_type;
    public $filters;
    public $display_columns;
    public $company_id;
    public $product_id;

    public $on_main_dashboard;

    public function scenarios()
    {
        return [
            Products::SCENARIO_CREATE => ['report_name', 'description', 'api_id', 'display_type', 'filters', 'display_columns', 'on_main_dashboard', 'company_id', 'product_id'],
            Products::SCENARIO_UPDATE => ['report_name', 'description', 'api_id', 'display_type', 'filters', 'display_columns', 'on_main_dashboard', 'company_id', 'product_id'],
            Products::SCENARIO_DEFAULT => ['report_name', 'description', 'api_id', 'display_type', 'filters', 'display_columns', 'on_main_dashboard', 'company_id', 'product_id'],
        ];
    }

    public function rules()
    {
        return [
            [['report_name', 'api_id', 'display_type', 'filters', 'summarize', 'on_main_dashboard', 'company_id'], 'required'],
            [['report_name', 'description'], 'string'],
            [['api_id', 'display_type', 'product_id'], 'integer'],
            [['display_columns'], "sanitizedata"],
            [['filters'], 'sanitizedata1']
        ];
    }

    public function afterValidate()
    {
        parent::afterValidate();
        $product = ProductsApiList::findOne(['id' => $this->api_id]);
        if (!empty($product)) {
            $this->product_id = $product->product_id;
        }
    }

    public function sanitizedata($attribute, $params)
    {
        if (!in_array($this->display_type,[Constants::DISPLAY_TYPE_TABLE,Constants::DISPLAY_TYPE_MULPLECARD])) {
            if (empty($this->$attribute['label']) || empty($this->$attribute['values']) || empty($this->$attribute['action'])) {
                $this->addError($attribute, 'Please fill all the fields');
            }
        } else {
            if (empty($this->$attribute['values'])) {
                $this->addError($attribute, 'Please fill all the fields');
            }
        }
    }

    public function sanitizedata1($attribute, $params)
    {
        $response = null;
        foreach ($this->$attribute as $key => $value) {
            if (!empty($value["attr"]) && !empty($value['val'])) {
                $response[$key] = $value;
            }
        }
        $this->$attribute = $response;
    }


    public function save()
    {
        if (!$this->hasErrors()) {
            $model = ProductsApiCompanyMapping::findOne(['id' => $this->id]);
            if (!$model instanceof ProductsApiCompanyMapping) {
                $model = new ProductsApiCompanyMapping(['scenario' => Products::SCENARIO_CREATE]);
            } else {
                $model->scenario = ProductsApiCompanyMapping::SCENARIO_UPDATE;
            }
            $model->product_id = $this->product_id;
            $model->company_id = $this->company_id;
            $model->api_id = $this->api_id;
            $model->report_name = $this->report_name;
            $model->display_type = $this->display_type;
            $model->filters = $this->filters;
            $model->display_columns = $this->display_columns;
            $model->on_main_dashboard = $this->on_main_dashboard;
            $model->status = Constants::STATUS_ACTIVE;
            if ($model->validate() && $model->save()) {
                return $model;
            }
        }
        return false;
    }
}