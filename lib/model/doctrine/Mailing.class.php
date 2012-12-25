<?php

/**
 * Mailing
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    SystemCore
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Mailing extends BaseMailing
{
	public function save(Doctrine_Connection $conn = null)
	{
		if($this->isNew())
		{
			$this->setHash(Tools::genUniqueHash(8));
		}
		return parent::save($conn);
	}	

	public function clearMailingList()
	{
		$q = Doctrine_Query::create()
			->from('Mailing2MailingList')
			->where('mailing_id =?', $this->getPrimaryKey())
			->delete();
		return $q->execute();
	}

	public function run()
	{
		if($this->getStatus() == 1)
		{
			$this->setStatus(2);
			$this->setTimeStart(date('Y-m-d: H:i:s', time()));

			$points = $this->setEmailsGroup();
			$this->publishHtml();

			$this->getUser()->takePoints($points);

			$this->save();
		}
			
	}

	public function test()
	{
		$title = $this->getTitle();
		$content = $this->getHtml();

		$user = $this->getUser();
		$emails = $user->getUserTestEmail();

		foreach($emails as $email)
		{
		 	$to = $email->getEmail();		
		 	Tools::sendEmail($to, $title, $content);	
		}				
	}

	private function setEmailsGroup()
	{
		$lists = $this->getMailingLists();
		$ids = array();
		foreach($lists as $list)
		{
			$ids = array_merge($ids, $list->getVeryfiedEmailIds());			
		}

		$this->link('MailingEmails', $ids);

		return count($ids);

	}

	private function publishHtml()
	{
		$this->setPublic($this->getHtml());
	}
}
