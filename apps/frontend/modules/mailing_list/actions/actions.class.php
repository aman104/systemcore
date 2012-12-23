<?php

/**
 * mailing_list actions.
 *
 * @package    SystemCore
 * @subpackage mailing_list
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mailing_listActions extends ApiActions
{

  public function SmPostExecute(sfWebRequest $request, User $user)
  {
      $params = array();
      $params = $request->getPostParameters();
      $list = $user->addMailingList($params);
      $return = $list->toArray();
      return $return;
  }

  public function SmGetExecute(sfWebRequest $request, User $user)
  {
      $hash = $request->getParameter('hash');
      $method = $request->getParameter('method');
      
      if($hash)
      {

        if(isset($method) && $method == 'clear')
        {

          $list = $user->getMailingListsByHash($hash);
          if($list)
          {

            $list->clear();
            $return = 'OK';  
          }
          else
          {
            $return = 'ERROR';
          }
        }
        else
        {
          $return = $user->getMailingListsByHash($hash)->toArray();  
        }
        
      }
      else
      {
        $return = $user->getMailingListsArray();  
      }    
      return $return;
  }

  public function SmPutExecute(sfWebRequest $request, User $user)
  {
    $hash = $request->getParameter('hash');
    $name = $request->getParameter('name');
    $list = $user->getMailingListsByHash($hash);
    if($list)
    {
      $list->setName($name);
      $list->save();
      return $list->toArray();
    }
    else
    {
      return false;
    }
  }

  public function SmDeleteExecute(sfWebRequest $request, User $user)
  {

    $hash = $request->getParameter('hash');
    $list = $user->getMailingListsByHash($hash);
    if($list)
    {
      $list->delete();
      $return = 'OK';
    }
    else
    {
      $return = 'ERROR';
    }
    return $return;    
  }
}

