<?php

/**
 * MailingTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class MailingTable extends Doctrine_Table
{
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Mailing');
    }

    public function getMailingsArrayByUser(User $user, $status = false)
    {

    	$q = Doctrine_Query::create()
    	 	->from('Mailing m')
            ->leftJoin('m.MailingEmails e')            
    	 	->where('m.user_id =?', $user->getPrimaryKey())
    	 	->andWhere('m.is_deleted =?', false)
            ->useQueryCache(null)
            ->useResultCache(null);
    	;
    	
    	if($status)
    	{
    		$q->addWhere('m.status =?', $status);
    	}    	

        $array = $q->fetchArray();
        $return = array();
        foreach($array as $one)
        {
            $tmp = $one;
            $tmp['MailingEmails'] = count($one['MailingEmails']);
            $return[] = $tmp;
        }

    	return $return;
    }

    public function getEmails(User $user, $hash = false, $status = false)
    {
        $q = Doctrine_Query::create()
            ->select('e.email, me.status')
            ->from('Email e')
            ->leftJoin('e.Mailing2Email me')
            ->leftJoin('me.Mailing m')
            ->where('m.user_id =?', $user->getPrimaryKey())
            ;

        if((int)$status > 0)
        {
            $q->andWhere('me.status =?', $status);
        }        
            

        if($hash)
        {
            $q->addWhere('m.hash =?', $hash);
        }

        return $q->fetchArray();
    }
}