<?php

namespace common\forms;

use common\models\User;

class UserForm extends \yii\base\Model {

    public $id;
    public $name;
    public $mobile_no;
    public $email;
    public $user_type;
    public $designation_id;
    public $username;
    public $password;
    public $status;
    public $reference_id;

    public function scenarios() {
        return [
            User::SCENARIO_CREATE => ['id', 'name', 'mobile_no', 'email', 'user_type', 'designation_id', 'username', 'status', 'password','reference_id'],
            User::SCENARIO_CONSOLE => ['id', 'name', 'mobile_no', 'email', 'user_type', 'designation_id', 'username', 'status', 'password','reference_id'],
            User::SCENARIO_UPDATE => ['id', 'name', 'mobile_no', 'email', 'user_type', 'designation_id', 'username', 'status', 'password','reference_id'],
        ];
    }

    public function rules() {
        return [
            [['name', 'mobile_no', 'user_type', 'designation_id', 'username', 'status'], 'required'],
            [['name', 'mobile_no', 'email', 'username', 'password'], 'string'],
            [['user_type', 'designation_id','reference_id'], 'integer']
        ];
    }

    public function attributeLabels() {
        return (new User())->attributeLabels();
    }

    public function save($runValidation = true, $attributeNames = null) {
        if (!$this->hasErrors()) {
            if ($this->id) {
                return $this->update();
            } else {
                return $this->create();
            }
        }
        return false;
    }

    public function create() {
        $model = new User(['scenario' => User::SCENARIO_CREATE]);
        $model->load($this->attributes, '');
        $model->password = md5($this->password);
        if ($model->validate() && $model->save()) {
            $this->id = $model->id;
            return TRUE;
        } else {
            $this->addErrors($model->errors);
        }
        return FALSE;
    }

    public function update() {
        $model = User::findOne($this->id);
        if ($model instanceof User) {
            $model->scenario = User::SCENARIO_UPDATE;
            echo "<pre>";
            $model->load($this->attributes, '');
            if (empty($this->password)) {
                $model->password = $model->oldAttributes['password'];
            }
            if ($model->validate() && $model->save()) {
                $this->id = $model->id;
                return TRUE;
            } else {
                $this->addErrors($model->errors);
            }
        }
        return false;
    }

}
