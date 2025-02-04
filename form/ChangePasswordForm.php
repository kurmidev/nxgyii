<?php

namespace common\forms;

use common\models\User;

class ChangePasswordForm extends \yii\base\Model {

    public $user_id;
    public $password;
    public $confirmpassword;
    public $name;

    public function scenarios() {
        return [
            User::SCENARIO_CREATE => ["user_id", "password", "confirmpassword"],
            User::SCENARIO_CONSOLE => ["user_id", "password", "confirmpassword"],
        ];
    }

    public function rules() {
        return [
            [["user_id", "password", "confirmpassword"], 'required'],
            ['password', 'compare', 'compareAttribute' => 'confirmpassword'],
            [["password", "confirmpassword"], 'string', 'min' => 6]
        ];
    }

    public function attributeLabels() {
        return [
            "password" => "Password",
            "confirmpassword" => "Confirm Password"
        ];
    }

    public function save() {
        if (!$this->hasErrors()) {
            $model = User::findOne(['id' => $this->user_id]);
            if ($model instanceof User) {
                $model->scenario = User::SCENARIO_UPDATE;
                $model->password = md5($this->password);
                $model->password_hash = \Yii::$app->security->generatePasswordHash($this->password);
                if ($model->validate() && $model->save()) {
                    return $model;
                }
            }
        }
        return FALSE;
    }

}
