<?php

namespace app\models;

use app\component\Constants;
use Yii;

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
            self::SCENARIO_CREATE => ['name', 'code', 'mobile_no', 'phone_no', 'email', 'gst_in', 'pan_no', 'pincode', 'logo', 'billing_address', 'status'],
            self::SCENARIO_UPDATE => ['name', 'code', 'mobile_no', 'phone_no', 'email', 'gst_in', 'pan_no', 'pincode', 'logo', 'billing_address', 'status'],
            self::SCENARIO_DEFAULT => ['name', 'code', 'mobile_no', 'phone_no', 'email', 'gst_in', 'pan_no', 'pincode', 'logo', 'billing_address', 'status', 'added_on', 'updated_on', 'added_by', 'updated_by'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'mobile_no', 'billing_address'], 'required'],
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

    /**
     * @inheritdoc
     * @return CompanyQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new CompanyQuery(get_called_class());
    }


}
