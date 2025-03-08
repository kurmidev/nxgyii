<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ProductUserMapping]].
 *
 * @see ProductUserMapping
 */
class ProductUserMappingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductUserMapping[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductUserMapping|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
