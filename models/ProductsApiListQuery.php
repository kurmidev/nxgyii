<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[ProductsApiList]].
 *
 * @see ProductsApiList
 */
class ProductsApiListQuery extends BaseQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return ProductsApiList[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return ProductsApiList|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
