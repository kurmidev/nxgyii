<?php

namespace app\models;

use app\component\Constants;
use Yii;

/**
 * This is the model class for table "product_master".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property string|null $service_provider
 * @property int $status
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class ProductMaster extends \app\models\BaseModel
{
    public $attrib;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_master';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','service_provider','status'], 'required'],
            [['description'], 'string'],
            [['status', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on','attrib'], 'safe'],
            [['name', 'code', 'service_provider'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['code'], 'unique'],
        ];
    }

    public function scenarios(){
        return [
            self::SCENARIO_CREATE => ['name', 'code','service_provider','status','attrib','description'],
            self::SCENARIO_UPDATE => ['name', 'code','service_provider','status','attrib','description'],
            self::SCENARIO_DELETE => ['name', 'code','service_provider','status','attrib','description'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'description' => 'Description',
            'service_provider' => 'Service Provider',
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    

    /** 
     * {@inheritdoc} 
     * @return ProductMasterQuery the active query used by this AR class. 
     */
    public static function find()
    {
        return new ProductMasterQuery(get_called_class());
    }


     /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        if ($this->scenario == self::SCENARIO_CREATE) {
            $this->code = empty($this->code) ? $this->generateCode(Constants::PREFIX_PRODUCT) : $this->code;
        }
        return parent::beforeSave($insert);
    }

    public function beforeValidate() {
        return parent::beforeValidate();
    }

    public function afterSave($insert, $changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        if (in_array($this->scenario,[self::SCENARIO_UPDATE,self::SCENARIO_CREATE])) {
            $this->productAttributes();
        }
    }

    public function getProductAttributes() {
        return $this->hasMany(ProductAttributes::class,["product_id"=>"id"]);
    }

    public function getSavedAttributes() {
        $attributes =[];
        foreach($this->productAttributes as $key=>$value){
            $attributes[$key]["attr_type"] = $value->attr_type;
            $attributes[$key]["attr_value"] = $value->attr_value;
        }
        return $attributes;
    }

    public function productAttributes(){
        ProductAttributes::deleteAll(['product_id'=>$this->id]);  // delete existing attributes first
        foreach($this->attrib as $attr){
            $productAttribute = new ProductAttributes(["scenario"=>ProductAttributes::SCENARIO_CREATE]);
            $productAttribute->product_id = $this->id;
            $productAttribute->attr_type = $attr["attr_type"];
            $productAttribute->attr_value = $attr["attr_value"];
            $productAttribute->save();
        }
    }
}
