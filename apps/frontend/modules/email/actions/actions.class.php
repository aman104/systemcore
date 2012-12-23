<?php

/**
 * email actions.
 *
 * @package    SystemCore
 * @subpackage email
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class emailActions extends ApiActions
{
 public function SmPostExecute(sfWebRequest $request, User $user)
  {
      $params = array();
      $params = $request->getPostParameters();      

      $list = $user->getMailingListsByHash($params['hash']);
      if($list)
      {
      	$email = $list->addEmail($params);
      	$return = $email;
      }
      else
      {
      	$return = null;
      }
      
      return $return;
  }

  public function SmGetExecute(sfWebRequest $request, User $user)
  {
  	  $hash = $request->getParameter('hash');       	  
  	  $email = $request->getParameter('email');
  	  $method = $request->getParameter('method');
  	  if(isset($email) && isset($hash))
  	  {
  	  	$mailingList = $user->getMailingListsByHash($hash);
  	  	
  	  	if(isset($method) && $method == 'verify')
  	  	{
  	  		$object = $mailingList->getIssetEmail($email, true);
  	  		$m2e = MailingList2EmailTable::getInstance()->findOnebyTwoIds($mailingList->getPrimaryKey(), $object->getPrimaryKey());
  	  		EmailTable::sendVerifiedLink($email, $hash, $m2e->getPrimaryKey());
  	  	}
  	  	else
  	  	{
  	  		$email = $mailingList->getIssetEmail($email);
	  	  	return $email;		
  	  	}  	  	
  	  }
      elseif(isset($hash))
      {
        $mailingList = $user->getMailingListsByHash($hash);
        if($mailingList)
        {        	
        	$return = $mailingList->getEmailsArray();
        }

      }
      else
      {
        $return = null;
      }    
      return $return;
  }

  public function SmPutExecute(sfWebRequest $request, User $user)
  {
  	  $hash = $request->getParameter('hash');       	  
  	  $email = $request->getParameter('email');
  	  $name = $request->getParameter('name');
  	  $phone = $request->getParameter('phone');
  	  $status = $request->getParameter('status');



  	  $mailingList = $user->getMailingListsByHash($hash);  	  
  	  $object = $mailingList->getIssetEmail($email, true);
  	  if($object)
  	  {  	  
  	  	$m2e = $object->getEmailDetails($hash);
  	  	$m2e->setName($name);
  	  	$m2e->setPhone($phone);
  	  	$m2e->setStatus($status);
  	  	$m2e->save();
  	  	return $mailingList->getIssetEmail($email, false);
  	  }
  	  else
  	  {
  	  	return 'ERROR';
  	  }

  }

  public function SmDeleteExecute(sfWebRequest $request, User $user)
  {
     $hash = $request->getParameter('hash');       	  
  	 $email = $request->getParameter('email');

  	 $mailingList = $user->getMailingListsByHash($hash);
  	 $object = $mailingList->getIssetEmail($email, true);
  	 if($object)
  	 { 
  	 	$m2e = $object->getEmailDetails($hash);
  	 	$m2e->delete();
  	 	return 'OK';
  	 }
  	 else
  	 {
  	 	return 'ERROR';
  	 }
  }
}
