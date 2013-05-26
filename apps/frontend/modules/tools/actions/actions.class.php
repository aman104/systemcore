<?php

/**
 * tools actions.
 *
 * @package    SystemCore
 * @subpackage tools
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class toolsActions extends sfActions
{
 
  public function executeAddSubscriber(sfWebRequest $request)
  {
    $this->email = $request->getParameter('sm_email');
    $name = $request->getParameter('sm_name');
    $phone = $request->getParameter('sm_phone');
    $hash = $request->getParameter('sm_mailing_list_hash');

    $this->url = $request->getReferer();

    if ( ! filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
    	$this->valid = true;
	}
	else
	{
		$list = MailingListTable::getInstance()->findOneByHash($hash);
	    if($list)
	    {
	    	$isset = $list->getIssetEmail($this->email, true);
	    	if( ! $isset) 
	    	{
	    		$params = array();
	    		$params['email'] = $this->email;
	    		if(isset($name))
	    		{
	    			$params['name'] = $name;
	    		}
	    		if(isset($phone))
	    		{
	    			$params['phone'] = $phone;
	    		}
	    		$params['status'] = 1;
	    		$list->addEmail($params);
	    		$this->add = true;
	    	}
	    	else
	    	{
	    		$m2e = $isset->getEmailDetails($hash);
	    		$m2e->delete();
	    		$this->delete = true;
	    	}
	    }	
	    else
	    {
	    	$this->validlist = true;
	    }
	}
    
  }

  public function executeVerified(sfWebRequest $request)
  {
  	$hash = $request->getParameter('hash');
  	$id = $request->getParameter('email');
  	$md5 = $request->getParameter('md5');  	
  	
	$list = MailingListTable::getInstance()->findOneByHash($hash);

	if($list)
	{
		$m2e = MailingList2EmailTable::getInstance()->findOnebyTwoIds($list->getPrimaryKey(), $id);
		if($m2e)	
		{
			$this->email = $m2e->getEmail()->getEmail();

		  	$_md5 = md5($this->email.$hash.'verify_link');

		  	if($_md5 == $md5)
		  	{  			
				$m2e->setStatus(2);
				$m2e->save();
				$this->ok = true;
		  	}
		  	else
		  	{
		  		$this->ok = false;
		  	}		
		}
		else
	  	{
	  		$this->ok = false;
	  	}		
	}
	else
	{
  		$this->ok = false;
  	}		  	  
  }

  public function executeRemove(sfWebRequest $request)
  {	
  	$hash = $request->getParameter('hash');
  	$id = $request->getParameter('email');
  	$md5 = $request->getParameter('md5');  	
  	
	$list = MailingListTable::getInstance()->findOneByHash($hash);
	
	if($list)
	{
		
		$m2e = MailingList2EmailTable::getInstance()->findOnebyTwoIds($list->getPrimaryKey(), $id);
		if($m2e)	
		{
			$this->email = $m2e->getEmail()->getEmail();

		  	$_md5 = md5($this->email.$hash.'delete_link');

		  	if($_md5 == $md5)
		  	{  			
				$m2e->delete();
				$this->ok = true;
		  	}
		  	else
		  	{
		  		$this->ok = false;
		  	}		
		}
		else
	  	{
	  		$this->ok = false;
	  	}		
	}
	else
	{
  		$this->ok = false;
  	}		  	  
  }

  public function executeLink(sfWebRequest $request)
  {
  	$hash = $request->getParameter('hash');
  	$link = MailingLinkTable::getInstance()->findOneByLink($hash);
  	if($link)
  	{
  		$count = $link->getClick();
  		$count++;
  		$link->setClick($count);
  		$link->save();
  		$this->redirect($link->getSource());
  	}
  }

  public function executePreview(sfWebRequest $request)
  {
  	$hash = $request->getParameter('hash');
  	$mailing = MailingTable::getInstance()->findOneByHash($hash);
  	if($mailing)
  	{
  		$html = $mailing->getHtml();
  		$html = $mailing->prepareHtml($html);
  		echo $html;
  		exit;
  	}
  }

  public function executeDeleteEmail(sfWebRequest $request)
  {

  	$hash = $request->getParameter('hash');
  	$mailing = MailingTable::getInstance()->findOneByHash($hash);
  	$this->email = urlencode($request->getParameter('email'));
  	$this->email = urldecode($this->email);

  	$q = Doctrine_Query::create()
  		->from('Email e')
  		->where('e.email =?', $this->email);
  
  	$emailObj = $q->fetchOne();

    if($emailObj)
    {
    	$this->ok = true;
    	$q = Doctrine_Query::create()
  		->from('Mailing2Email m2e')
  		->where('m2e.mailing_id =?', $mailing->getPrimaryKey())
  		->andWhere('m2e.email_id =?', $emailObj->getPrimaryKey());
  		$m2e = $q->fetchOne();
  		$m2e->setStatus(3);
	  	$m2e->save();

	  	$mailingList = $mailing->getMailingLists();
	  	$ids = array();
	  	foreach($mailingList as $list)
	  	{
	  		$ids[] = $list->getPrimaryKey();
	  	}
	  	$q = Doctrine_Query::create()
	  		->from('MailingList2Email ml2e')
	  		->WhereIn('ml2e.mailing_list_id', $ids)
	  		->andWhere('ml2e.email_id =?', $emailObj->getPrimaryKey());
	  	$ml2e = $q->execute();
	  	foreach($ml2e as $one)
		{
			$one->delete();
		}	  		

    }  	
    else
    {
    	$this->ok = false;
    }

  }

  public function executeOpenEmail(sfWebRequest $request)
  {

  	$hash = $request->getParameter('hash');
  	$mailing = MailingTable::getInstance()->findOneByHash($hash);
  	$this->email = urlencode($request->getParameter('email'));
  	$this->email = urldecode($this->email);


  	$q = Doctrine_Query::create()
  		->from('Email e')
  		->where('e.email =?', $this->email);
  
  	$emailObj = $q->fetchOne();

    if($emailObj)
    {
    	$q = Doctrine_Query::create()
  		->from('Mailing2Email m2e')
  		->where('m2e.mailing_id =?', $mailing->getPrimaryKey())
  		->andWhere('m2e.email_id =?', $emailObj->getPrimaryKey());
  		$m2e = $q->fetchOne();
  		$m2e->setStatus(4);
	  	$m2e->save();
	}

  	header( "Content-type: image/gif"); 
	header( "Expires: Wed, 5 Feb 1986 06:06:06 GMT"); 
	header( "Cache-Control: no-cache"); 
	header( "Cache-Control: must-revalidate"); 

	printf ('%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%c%', 71,73,70,56,57,97,1,0,1,0,128,255,0,192,192,192,0,0,0,33,249,4,1,0,0,0,0,44,0,0,0,0,1,0,1,0,0,2,2,68,1,0,59);
  	exit;
  }

  public function executeMailingRun(sfWebRequest $request)
  {
  	header('Access-Control-Allow-Origin:  http://send24mail.pl');
  	$hash = $request->getParameter('hash');
  	$mailing = MailingTable::getInstance()->findOneByHash($hash);
  	$user = $mailing->getUser();
  	$emails = MailingTable::getInstance()->getEmails($user, $hash, 2);
  	echo count($emails);
  	exit;
  }

  public function executePayment(sfWebRequest $request)
  {
  	$hash = $request->getParameter('hash');
  	$payment = PaymentTable::getInstance()->findOneByHash($hash);

  	if($payment)
  	{
  		$payment->setStatus(2);
  		$payment->save();
  		$data = $payment->getUser()->getUserData();
  		$point = $data->getPoint() + $payment->getPoints();
  		$data->setPoint($point);
  		$data->save();

      $payment->generateInvoice();

  	}

  	$this->redirect('http://send24mail.pl/user/invoice');

  }

  public function executeDownload(sfWebRequest $request)
  {

      $payment = $this->getRoute()->getObject();

      ob_end_clean();
      header('Content-type: application/octet-stream', true);
      header('Content-Disposition: attachment; filename="invoice.pdf"');
      header('Pragma: no-cache', true);

      $invoice = STG_WFirma_API::getInstance();
      $response = $invoice->downloadInvoice($payment->getInvoiceId());

      return $this->renderText($response);
  }

}
