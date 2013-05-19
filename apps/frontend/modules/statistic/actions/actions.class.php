<?php

/**
 * statistic actions.
 *
 * @package    SystemCore
 * @subpackage statistic
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class statisticActions extends ApiActions
{
 	public function SmPostExecute(sfWebRequest $request, User $user)
 	{

 	}

 	public function SmGetExecute(sfWebRequest $request, User $user)
 	{
  	   $return = 'ERROR';

 	     $hash = $request->getParameter('mailing_hash');       	  
  	   $method = $request->getParameter('method');

       if($method == 'emails')
       {
          $return = MailingTable::getInstance()->getEmails($user, $hash, $request->getParameter('status'));
       }  
       elseif($method == 'mailing_list_emails')
       {
          $return = MailingListTable::getInstance()->getEmails($user, $request->getParameter('status'));
       } 
       else
       {
        $mailing = $user->getMailingByHash($hash, true);

         if($mailing)
         {
           if($method == 'links')
           {
              $return = $mailing->getMailingLinks()->toArray();
           }
           
        } 
      }
  	     	 
      return $return;
 	}

 	public function SmPutExecute(sfWebRequest $request, User $user)
 	{
 		
 	}

 	public function SmDeleteExecute(sfWebRequest $request, User $user)
 	{
 		
 	}
}
