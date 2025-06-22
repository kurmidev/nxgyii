<?php

namespace app\models;

use app\component\Constants as C;
use app\models\User;
use Yii;

class BaseQuery extends \yii\db\ActiveQuery
{

    public $tableAlias;

    public function active()
    {
        return $this->andWhere([$this->tableAlias . 'status' => C::STATUS_ACTIVE]);
    }

    public function inActive()
    {
        return $this->andWhere([$this->tableAlias . 'status' => C::STATUS_INACTIVE]);
    }

    public function excludeSysDef()
    {
        return $this->andWhere(['>', $this->tableAlias . 'id', 0]);
    }

    public function defaultCondition($alias = "")
    {
       return $this;
    }

    public function setAlias($d)
    {
        $this->tableAlias = !empty($d) ? $d . "." : "";
        return $this->alias($d);
    }

    public function getTalias()
    {
        list(, $alias) = $this->getTableNameAndAlias();
        return "$alias.";
    }

    public function getRawSql()
    {
        return $this->createCommand()->getRawSql();
    }

}
