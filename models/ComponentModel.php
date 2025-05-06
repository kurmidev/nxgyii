<?php

use app\models\Products;

class ComponentModel extends \yii\base\Model{

    public $title;
    public $description;
    public $api_id;

    public $display_type;
    public $filters;
    public $summarize;

    public function scenarios(){
        return [
            Products::SCENARIO_CREATE => ['title','description','api_id','display_type','filters','summarize'],
            Products::SCENARIO_UPDATE => ['title','description','api_id','display_type','filters','summarize'],
            Products::SCENARIO_DEFAULT=> ['title','description','api_id','display_type','filters','summarize'],
        ];
    }

    public function rules(){
        return [
            [['title','description','api_id','display_type','filters','summarize'],'required'],
            [['title','description'],'string'],
            [['api_id','display_type'],'integer'],
            [['filters','summarize'],"validateMultipleData"]
        ];
    }

    public function validateMultipleData($attribute, $params){
        if(is_array($this->$attribute)){
            foreach ($this->$attribute as $key=>$value){
                if(!is_array($value)){
                    $this->addError($attribute,"Invalid value for $attribute");
                }
            }
        }
    }

    public function save(){
        $model = new Products();
        $model->setAttributes($this->attributes);
        $model->scenario = Products::SCENARIO_CREATE;
        if($model->save()){
            return true;
        }
        return false;
    }
}