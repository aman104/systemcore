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

}
