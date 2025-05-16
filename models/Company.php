<?php

namespace app\models;

use app\component\Constants;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "company".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $mobile_no
 * @property string|null $phone_no
 * @property string|null $email
 * @property string|null $gst_in
 * @property string|null $pan_no
 * @property string $billing_address
 * @property string|null $pincode
 * @property string|null $logo
 * @property int $status
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class Company extends \app\models\BaseModel
{
    public $product_mappings;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'company';
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_CREATE => ['name', 'code', 'mobile_no', 'phone_no', 'email', 'gst_in', 'pan_no', 'pincode', 'logo', 'billing_address', 'status','product_mappings'],
            self::SCENARIO_UPDATE => ['name', 'code', 'mobile_no', 'phone_no', 'email', 'gst_in', 'pan_no', 'pincode', 'logo', 'billing_address', 'status','product_mappings'],
            self::SCENARIO_DEFAULT => ['name', 'code', 'mobile_no', 'phone_no', 'email', 'gst_in', 'pan_no', 'pincode', 'logo', 'billing_address', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'mobile_no', 'billing_address','product_mappings'], 'required'],
            ['product_mappings', 'each', 'rule' => ['integer']],
            [['status', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
            [['name', 'code', 'mobile_no', 'phone_no', 'email', 'gst_in', 'pan_no', 'billing_address', 'pincode', 'logo'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['code'], 'unique'],
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
            'mobile_no' => 'Mobile No',
            'phone_no' => 'Phone No',
            'email' => 'Email',
            'gst_in' => 'Gst In',
            'pan_no' => 'Pan No',
            'billing_address' => 'Billing Address',
            'pincode' => 'Pincode',
            'logo' => 'Logo',
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }


    public function beforeValidate()
    {
        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if ($this->scenario == self::SCENARIO_CREATE) {
            $this->code = empty($this->code) ? $this->generateCode(Constants::PREFIX_COMPANY) : $this->code;
        }
        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes){
        if(in_array($this->scenario, [self::SCENARIO_CREATE, self::SCENARIO_UPDATE])){
            $this->addProductMappings($this->product_mappings);
        }
    }

    /**
     * @inheritdoc
     * @return CompanyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyQuery(get_called_class());
    }

    public function getProductMappings(){
        return $this->hasMany(ProductUserMapping::class,['user_id'=>'id'])->andOnCondition(['user_type'=>ProductUserMapping::USER_TYPE_COMPANY]);
    }

    public function addProductMappings($product_mappings){
        if(!empty($product_mappings)){
            ProductUserMapping::deleteAll(["user_id"=>$this->id,'user_type'=>ProductUserMapping::USER_TYPE_COMPANY]);
        }
        foreach($product_mappings as $product_id){
            $model = new ProductUserMapping(['scenario'=>ProductUserMapping::SCENARIO_CREATE]);
            $model->product_id = $product_id;
            $model->user_id = $this->id;
            $model->user_type = ProductUserMapping::USER_TYPE_COMPANY;
            if($model->validate() && $model->save()){
                //do notthings
            }
        }
    }

    public function getProduct_mappings(){
        return !empty($this->productMappings)?ArrayHelper::getColumn($this->productMappings,'product_id'):[];
    }

    public function getAssignedApiList(){
        $m = ProductCompanyMapping::find()->where(['company_id'=>$this->id])->asArray()->all();
        if(!empty($m)){
            $api_list = [];
            foreach($m as $item){
                $api_list = array_merge($api_list,json_decode($item['allowed_api'],true));
            }
            return $api_list;
        }
        return [];
    }

}
