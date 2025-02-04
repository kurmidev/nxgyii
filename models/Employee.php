<?php

namespace app\models;

use app\component\Constants;
use PHPUnit\TextUI\Configuration\Constant;
use Yii;

/**
 * This is the model class for table "employee".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string $mobile_no
 * @property string|null $phone_no
 * @property string|null $email
 * @property string $address
 * @property string|null $pincode
 * @property int|null $company_id
 * @property int|null $designation_id
 * @property int $status
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 *
 * @property Company $company
 * @property Designation $designation
 */
class Employee extends \app\models\BaseModel
{
    public $password;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'employee';
    }

    public function scenarios(){
        return [
            self::SCENARIO_CREATE => ['name', 'code','mobile_no', 'address','password','phone_no','email','status','company_id','designation_id'],
            self::SCENARIO_UPDATE => ['name', 'code','mobile_no', 'address','password','phone_no','email','status','company_id','designation_id'],
            self::SCENARIO_DEFAULT => ['name', 'code','mobile_no', 'address','password','phone_no','email','status','company_id','designation_id'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'mobile_no', 'address'], 'required'],
            [['company_id', 'designation_id', 'status', 'added_by', 'updated_by'], 'integer'],
            [['added_on', 'updated_on'], 'safe'],
            [['name', 'code', 'mobile_no', 'phone_no', 'email', 'address', 'pincode','password'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['code'], 'unique'],
            [['email'], 'unique', 'targetClass' => User::class, 'targetAttribute' => ['email' => 'email']],
            [['company_id'], 'exist', 'skipOnError' => true, 'targetClass' => Company::class, 'targetAttribute' => ['company_id' => 'id']],
            [['designation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Designation::class, 'targetAttribute' => ['designation_id' => 'id']],
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
            'address' => 'Address',
            'pincode' => 'Pincode',
            'company_id' => 'Company ',
            'designation_id' => 'Designation ',
            'status' => 'Status',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * Gets query for [[Company]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getCompany()
    {
        return $this->hasOne(Company::class, ['id' => 'company_id']);
    }

    /**
     * Gets query for [[Designation]].
     *
     * @return \yii\db\ActiveQuery|yii\db\ActiveQuery
     */
    public function getDesignation()
    {
        return $this->hasOne(Designation::class, ['id' => 'designation_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['email' => 'email']);
    }


    /**
     * {@inheritdoc}
     * @return EmployeeQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new EmployeeQuery(get_called_class());
    }

    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        if($insert){
            $user = new User(["scenario"=>User::SCENARIO_CREATE]);
            $user->name = $this->name;
            $user->mobile_no = $this->mobile_no;
            $user->user_type = Constants::USERTYPE_CLIENT ;
            $user->company_id = $this->company_id;
            $user->client_id = $this->id;
            $user->designation_id = $this->designation_id;
            $user->status = $this->status;
            $user->username = $user->email = $this->email;
            $user->password = md5($this->password);
            $user->password_hash = Yii::$app->security->generatePasswordHash($this->password);
            $user->auth_key = Yii::$app->security->generateRandomString();
            $user->setPassword('password');
            $user->generateAuthKey();
            if($user->validate() && $user->save()){
                return true;
            }
        }
        return false;
    }


     /**
     * @inheritdoc
     */
    public function beforeSave($insert) {
        if ($this->scenario == self::SCENARIO_CREATE) {
            $this->code = empty($this->code) ? $this->generateCode(Constants::PREFIX_DESIG) : $this->code;
        }
        return parent::beforeSave($insert);
    }

}
