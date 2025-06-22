<?php

namespace app\models;

use app\component\Constants as C;
use Yii;

/**
 * This is the ActiveQuery class for [[User]].
 *
 * @see User
 */
class CompanyQuery extends BaseQuery
{
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return Company[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return Company|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function excludeHighGrnd()
    {
        return $this;
        //return $this->andWhere(['not in', 'user_type', [ C::USERTYPE_MSO, C::USERTYPE_SUBSCRIBER]]);
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
                    print_R($company_id);
                }
                $this->andWhere(['id' => $company_id]);
                return $this;
            default:
                return $this;
        }
    }

}
