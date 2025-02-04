<?php

namespace app\models;

use app\component\Constants as C;
use app\models\User;

class BaseQuery extends \yii\db\ActiveQuery {

    public $tableAlias;

    public function active() {
        return $this->andWhere([$this->tableAlias . 'status' => C::STATUS_ACTIVE]);
    }

    public function inActive() {
        return $this->andWhere([$this->tableAlias . 'status' => C::STATUS_INACTIVE]);
    }

    public function excludeSysDef() {
        return $this->andWhere(['>', $this->tableAlias . 'id', 0]);
    }

    public function defaultCondition($alias = "") {
        // $this->tableAlias = !empty($alias) ? (strpos($alias, '.') ? $alias : "$alias.") : $alias;
        // $userType = User::loggedInUserType();
        // $currentUserId = User::loggedInUserReferenceId();
        // $c = new $this->modelClass();
        // if (in_array('operator_id', array_keys($c->attributes))) {
        //     if ($userType <= C::USERTYPE_MSO) {
        //         return $this;
        //     } elseif (in_array($userType, [C::USERTYPE_CLIENT])) {
        //         $opt = Operator::find()->where(['OR', ['distributor_id' => $currentUserId], ['id' => $currentUserId], ['ro_id' => $currentUserId]])
        //                         ->indexBy('id')->asArray()->all();
        //         if (!empty($opt)) {
        //             return $this->andWhere([$this->tableAlias . 'operator_id' => array_keys($opt)]);
        //         }
        //     } else {
        //         $key = User::loggedInUserId();
        //         $op_id = Yii::$app->user->identity->getAssignedList();
        //         if (empty($op_id)) {
        //             return $this->andWhere([$this->tableAlias . 'operator_id' => $op_id]);
        //         }
        //     }
        // }
        return $this;
    }

    public function setAlias($d) {
        $this->tableAlias = !empty($d) ? $d . "." : "";
        return $this->alias($d);
    }

    public function getTalias() {
        list(, $alias) = $this->getTableNameAndAlias();
        return "$alias.";
    }

    public function getRawSql() {
        return $this->createCommand()->getRawSql();
    }

}
