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

	public function save(Doctrine_Connection $conn = null)
	{
		if($this->isNew())
		{
			$this->setApiToken(Tools::genUniqueHash(30));
			$this->setApiSecret(Tools::genUniqueHash(30));
		}
		return parent::save($conn);
	}

	public function addMailingList($params)
	{
		$list = new MailingList();
		$list->setUser($this);
		$list->setName($params['name']);
		$list->save();
		return $list;
	}

	public function addMailing($params)
	{
		$mailing = new Mailing();
		$mailing->setUserId($this->getPrimaryKey());
		$mailing->setTitle($params['title']);
		$mailing->setHtml($params['html']);
		$mailing->setText($params['text']);
		$mailing->setStatus($params['status']);
		$mailing->save();

		foreach($params['mailing_list'] as $one)
		{
			$list = $this->getMailingListsByHash($one);
			if($list)
			{
				$m2l = new Mailing2MailingList();
				$m2l->setMailingId($mailing->getPrimaryKey());
				$m2l->setMailingListId($list->getPrimaryKey());
				$m2l->save();
			}
		}

		return $mailing;
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

	public function getMailingByHash($hash, $object = false)
	{
		$q = Doctrine_Query::create()
			->from('Mailing m')
			->leftJoin('m.MailingLists ml')
			->where('m.user_id =?', $this->getPrimaryKey())
			->andWhere('m.hash =?', $hash)
			->limit(1)
		;

		$obj = $q->fetchOne();

		if($object)
		{
			return $obj;
		}
		else
		{

			$array = $obj->toArray();
			$emails = count($obj->getMailingEmails());
			$array['emails'] = $emails;

			return $array;
		}
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

	public function returnToArray()
	{
		$array = array();
		$array['api_secret'] = $this->getApiSecret();
		$array['api_token'] = $this->getApiToken();
		$array['username'] = $this->getUsername();
		$array['first_name'] = $this->getFirstName();
		$array['last_name'] = $this->getLastName();
		$array['street'] = $this->getStreet();
		$array['post_code'] = $this->getPostCode();
		$array['city'] = $this->getCity();
		$array['country'] = $this->getCountry();
		$array['phone'] = $this->getPhone();
		$array['nip'] = $this->getNip();
		return $array;
	}

	public function takePoints($take)
	{
		$data = $this->getUserData();
		$points = $data->getPoint();
		$points -= $take;
		if($points < 0)
		{
			$points = 0;
		}
		$data->setPoint($points);
		$data->save();
	}

	public function setTestEmails($emails)
	{
		$olds = $this->getUserTestEmail();
		foreach($olds as $old)
		{
			$old->delete();
		}
		for($i == 1; $i <= 5; $i++)
		{
			if(isset($emails['emails_'.$i]) && $emails['emails_'.$i] != '')
			{
				$testEmail = new UserTestEmail();
				$testEmail->setUserId($this->getPrimaryKey());
				$testEmail->setEmail($emails['emails_'.$i]);
				$testEmail->save();
			}
		}
		
	}

}
