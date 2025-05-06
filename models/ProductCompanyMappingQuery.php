<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ProductCompanyMapping]].
 *
 * @see ProductCompanyMapping
 */
class ProductCompanyMappingQuery extends BaseQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductCompanyMapping[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductCompanyMapping|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
