<?php

namespace app\models;

use app\component\Constants as C;

/**
 * This is the ActiveQuery class for [[User]].
 *
 * @see User
 */
class UserQuery extends BaseQuery {
    /* public function active()
      {
      return $this->andWhere('[[status]]=1');
      } */

    /**
     * {@inheritdoc}
     * @return User[]|array
     */
    public function all($db = null) {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return User|array|null
     */
    public function one($db = null) {
        return parent::one($db);
    }

    public function excludeHighGrnd() {
        return $this;
        //return $this->andWhere(['not in', 'user_type', [ C::USERTYPE_MSO, C::USERTYPE_SUBSCRIBER]]);
    }

}
