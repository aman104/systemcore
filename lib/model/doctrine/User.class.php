<?php

/**
 * User
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    SystemCore
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class User extends BaseUser
{

	public function addMailingList($params)
	{
		$list = new MailingList();
		$list->setUser($this);
		$list->setName($params['name']);
		$list->save();
		return $list;
	}

	public function getMailingListsByHash($hash)
	{
		$q = Doctrine_Query::create()
			->from('MailingList')
			->where('user_id =?', $this->getPrimaryKey())
			->andWhere('hash =?', $hash)
		;
		return $q->fetchOne();
	}

	public function getMailingListsArray()
	{

		$q = Doctrine_Query::create()
			->from('MailingList m')
			->leftJoin('m.MailingList2Email e')			
			->where('m.user_id =?', $this->getPrimaryKey())
		;

		$return = array();
		$array = $q->fetchArray();

		//return $array;

		foreach($array as $one)
		{	
		  	$tmp = array();
		  	$tmp['name'] = $one['name'];
		 	$tmp['hash'] = $one['hash'];
		 	$tmp['created_at'] = $one['created_at'];

		 	$emails = 0;
		 	$verified = 0;
		 	foreach($one['MailingList2Email'] as $one_email)
		 	{
		 		$emails++;
		 		if($one_email['status'] == 2)
		 		{
		 			$verified++;	
		 		}		 		
		 	}

		 	$tmp['emails'] = $emails;
		 	$tmp['verified'] = $verified;
		 	$return[] = $tmp;
		
		}
		
		return $return;
	}

}