<?php

/**
 * MailingListTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class MailingListTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object MailingListTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('MailingList');
    }

    public function getEmails(User $user, $status = false)
    {
        $q = Doctrine_Query::create()
            ->select('e.email')
            ->from('Email e')
            ->leftJoin('e.MailingList2Email me')
            ->leftJoin('me.MailingList m')
            ->where('m.user_id =?', $user->getPrimaryKey())
            ;

        if((int)$status > 0)
        {
            $q->andWhere('me.status =?', (int)$status);
        }

        return $q->fetchArray();
    }
}