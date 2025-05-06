<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ProductsApiCompanyMapping]].
 *
 * @see ProductsApiCompanyMapping
 */
class ProductsApiCompanyMappingQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductsApiCompanyMapping[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductsApiCompanyMapping|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
