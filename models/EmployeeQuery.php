<?php

namespace app\models;
use app\component\Constants as C;
use Yii;

/**
 * This is the ActiveQuery class for [[Employee]].
 *
 * @see Employee
 */
class EmployeeQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return Employee[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Employee|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

     public function defaultCondition($alias = "")
    {
        $userType = User::loggedInUserType();
        switch ($userType) {
            case C::USERTYPE_ADMIN:
                return $this;
            case C::USERTYPE_COMPANY || C::USERTYPE_CLIENT:
                $user = Yii::$app->user->identity;
                if (!empty($user)) {
                    $company_id = $user->company_id;
                }
                $this->andWhere(['company_id' => $company_id]);
                return $this;
            default:
                return $this;
        }
    }
}
