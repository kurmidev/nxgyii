<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ProductAttributes]].
 *
 * @see ProductAttributes
 */
class ProductAttributesQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductAttributes[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductAttributes|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
