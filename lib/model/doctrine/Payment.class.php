<?php

/**
 * Payment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    SystemCore
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Payment extends BasePayment
{
	public function save(Doctrine_Connection $conn = null)
	{
		if($this->isNew())
		{
			$this->setHash(Tools::genUniqueHash(10));
		}
		return parent::save($conn);
	}
}
