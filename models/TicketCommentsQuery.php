<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[TicketComments]].
 *
 * @see TicketComments
 */
class TicketCommentsQuery extends BaseQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * {@inheritdoc}
     * @return TicketComments[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return TicketComments|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
