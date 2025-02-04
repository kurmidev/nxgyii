<?php

namespace app\models;

use app\component\AuthUser;
use Yii;
use app\component\Constants as C;
use yii\base\NotSupportedException;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string|null $mobile_no
 * @property string|null $email
 * @property int $user_type
 * @property int|null $company_id
 * @property int|null $client_id
 * @property int|null $designation_id
 * @property string $username
 * @property string $password
 * @property string $auth_key
 * @property string $password_hash
 * @property string|null $verification_token
 * @property string|null $password_reset_token
 * @property int $status
 * @property string|null $last_access_time
 * @property string $added_on
 * @property string|null $updated_on
 * @property int|null $added_by
 * @property int|null $updated_by
 */
class User extends \app\models\BaseModel  implements IdentityInterface 
{
    public static $loggedInUser;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }


    public function scenarios() {
        return[
            self::SCENARIO_DEFAULT => ['*'], // Also tried without this line
            self::SCENARIO_CREATE => ['id', 'name', 'user_type', 'company_id', 'username', 'password', 'auth_key', 'password_hash', 'password_reset_token', 'status', 'last_access_time', 'added_on', 'updated_on', 'added_by', 'updated_by', 'verification_token', 'mobile_no', 'designation_id', 'email','client_id'],
            self::SCENARIO_CONSOLE => ['id', 'name', 'user_type', 'company_id', 'username', 'password', 'auth_key', 'password_hash', 'password_reset_token', 'status', 'last_access_time', 'added_on', 'updated_on', 'added_by', 'updated_by', 'verification_token', 'mobile_no', 'designation_id', 'email','client_id'],
            self::SCENARIO_UPDATE => ['id', 'name', 'user_type', 'company_id', 'username', 'password', 'auth_key', 'password_hash', 'password_reset_token', 'status', 'last_access_time', 'added_on', 'updated_on', 'added_by', 'updated_by', 'verification_token', 'mobile_no', 'designation_id', 'email','client_id'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'user_type', 'username', 'password', 'auth_key', 'password_hash'], 'required'],
            [['user_type', 'company_id', 'client_id', 'designation_id', 'status', 'added_by', 'updated_by','client_id'], 'integer'],
            [['last_access_time', 'added_on', 'updated_on'], 'safe'],
            [['name', 'mobile_no', 'email', 'username', 'password', 'password_hash', 'verification_token', 'password_reset_token'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],
            [['username'], 'unique'],
            [['password_reset_token'], 'unique'],
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
            'mobile_no' => 'Mobile No',
            'email' => 'Email',
            'user_type' => 'User Type',
            'company_id' => 'Company ID',
            'client_id' => 'Client ID',
            'designation_id' => 'Designation ID',
            'username' => 'Username',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'verification_token' => 'Verification Token',
            'password_reset_token' => 'Password Reset Token',
            'status' => 'Status',
            'last_access_time' => 'Last Access Time',
            'added_on' => 'Added On',
            'updated_on' => 'Updated On',
            'added_by' => 'Added By',
            'updated_by' => 'Updated By',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => C::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => C::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => C::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds user by verification email token
     *
     * @param string $token verify email token
     * @return static|null
     */
    public static function findByVerificationToken($token) {
        return static::findOne([
                    'verification_token' => $token,
                    'status' => C::STATUS_INACTIVE
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * {@inheritdoc}
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken() {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    public function getDesignation() {
        return $this->hasOne(Designation::class, ['id' => 'designation_id']);
    }

    
    public function beforeValidate() {
        return parent::beforeValidate();
    }

    public function afterValidate() {
        if (in_array($this->scenario, [self::SCENARIO_CREATE, self::SCENARIO_UPDATE])) {
            $this->auth_key = !empty($this->auth_key) ? $this->auth_key : Yii::$app->security->generateRandomString();
            $this->password_hash = !empty($this->password_hash) ? $this->password_hash : Yii::$app->getSecurity()->generatePasswordHash($this->username . $this->password);
        }

        return parent::afterValidate();
    }

    public function afterSave($insert, $changedAttributes) {

        if ($insert) {
            $desig = Designation::find()->andWhere(['id' => [$this->designation_id]])->indexBy('id')->one();
            if ($desig instanceof Designation) {
                echo "insise designation.........";
                AuthUser::assignDesignation($this->id, $desig->name);
            }
        }

        if (in_array("designation_id", array_keys($changedAttributes))) {
            if (!empty($changedAttributes['designation_id'])) {
                $desig = Designation::find()
                                ->andWhere(['id' => [$this->designation_id, $changedAttributes['designation_id']]])
                                ->indexBy('id')->all();

                if (!empty($desig)) {
                    $current = $desig[$this->designation_id];
                    $prev = $desig[$changedAttributes['designation_id']];
                    AuthUser::assignDesignation($this->id, $current->name, $prev->name);
                }
            }
        }
    }

    public static function currentUser() {
        if (!Yii::$app->user->isGuest) {
            if (!empty(Yii::$app->user)) {
                self::$loggedInUser =Yii::$app->user->getIdentity();
                return self::$loggedInUser;
            } else if (Yii::$app->user == 'ims-console') {
                return C::CONSOLE_ID;
            }
        }
    }

    public static function loggedInUserId() {
        $d = self::currentUser();
        return !empty($d['id']) ? $d['id'] : "";
    }

    public static function loggedInUserName() {
        $d = self::currentUser();
        return !empty($d['name']) ? $d['name'] : "";
    }

    public static function loggedInUserLoginId() {
        $d = self::currentUser();
        return !empty($d['username']) ? $d['username'] : "";
    }

    public static function loggedInUserType() {
        $d = Yii::$app->user->getIdentity();
        return !empty($d['user_type']) ? $d['user_type'] : "";
    }

    public static function loggedInUserReferenceId() {
        $d = Yii::$app->user->getIdentity();
        return !empty($d['reference_id']) ? $d['reference_id'] : "";
    }

    /**
     * @inheritdoc
     * @return UserQuery the active query used by this AR class.
     */
    public static function find() {
        return new UserQuery(get_called_class());
    }

}
