<?php

/**
 * mailing actions.
 *
 * @package    SystemCore
 * @subpackage mailing
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mailingActions extends ApiActions
{
  public function SmPostExecute(sfWebRequest $request, User $user, $params)
  {      
  	  if(isset($params['hash']))
  	  {
  	  	$return = $this->SmPutExecute($request, $user, $params);
  	  }
  	  else
  	  {
  	  	$mailing = $user->addMailing($params);      
      	$return = $mailing->toArray();	
  	  }      
      return $return;
  }

  public function SmGetExecute(sfWebRequest $request, User $user)
  {

  	  $status = $request->getParameter('status');
  	  if((int)$status > 0)
  	  {  	  	
  	  	$return = MailingTable::getInstance()->getMailingsArrayByUser($user, $status);
  	  }

  	  $hash = $request->getParameter('hash');
  	  $method = $request->getParameter('method');

  	  if(isset($hash))
  	  {
  	  	if($method == 'run')
  	  	{
  	  		$mailing = $user->getMailingByHash($hash, true);
  	  		$mailing->run();
  	  		$return = $mailing->toArray();
  	  	}
  	  	elseif($method == 'test')
  	  	{
  	  		$mailing = $user->getMailingByHash($hash, true);
  	  		$mailing->test();
  	  		$return = $mailing->toArray();
  	  	}
  	  	else
  	  	{
  	  		$return = $user->getMailingByHash($hash);	
  	  	}
  	  	
  	  }

  	  return $return;
  }

  public function SmPutExecute(sfWebRequest $request, User $user, $params)
  {  	  
  	//return $params; 	
  	$mailing = $user->getMailingByHash($params['hash'], true);
  	if($mailing)
  	{  	
  	 	$mailing->setTitle($params['title']);	
  	 	$mailing->setHtml($params['html']);
  	 	$mailing->setText($params['text']);
  	 	$mailing->save();
  	 	$mailing->clearMailingList();
		foreach($params['mailing_list'] as $one)
		{
			$list = $user->getMailingListsByHash($one);
			if($list)
			{
				$m2l = new Mailing2MailingList();
				$m2l->setMailingId($mailing->getPrimaryKey());
				$m2l->setMailingListId($list->getPrimaryKey());
				$m2l->save();
			}
		}

		$mailing = $user->getMailingByHash($params['hash'], true);

  	 	return $mailing->toArray();
  	}
  	return 'ERROR';

  }

  public function SmDeleteExecute(sfWebRequest $request, User $user)
  {
     $hash = $request->getParameter('hash');

     $mailing = $user->getMailingByHash($hash, true);
     if($mailing)
     {
     	
     	switch($mailing->getStatus())
     	{
     		case 1 : 
     			$mailing->delete();
     			break;
     		case 3 :
     			$mailing->setIsDeleted(true);
     			$mailing->save();
     			break;
     	}
     }
     return 'OK';
  }  
}
