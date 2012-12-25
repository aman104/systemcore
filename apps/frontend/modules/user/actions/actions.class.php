<?php

/**
 * user actions.
 *
 * @package    SystemCore
 * @subpackage user
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class userActions extends ApiActions
{
  public function SmGetExecute(sfWebRequest $request, User $user)
  {
  	$method = $request->getParameter('method');
  	if(isset($method) && $method == 'points')
  	{
  		return $user->getUserData()->getPoint();
  	}
    elseif(isset($method) && $method == 'emails')
    {
      return $user->getUserTestEmail()->toArray();
    }
    elseif(isset($method) && $method == 'verify')
    {
      return $user->getUserData()->getVerify();
    }    
    else
    {
      return $user->toArray();
    }
  }

  public function SmPostExecute(sfWebRequest $request, User $user)
  {
  	
  }

  public function SmPutExecute(sfWebRequest $request, User $user, $params)
  {
     if(isset($params['method']) && $params['method'] == 'emails')
     {
         $user->setTestEmails($params);
         return $user->getUserTestEmail()->toArray();
     }
     if(isset($params['method']) && $params['method'] == 'verify')
     {
         $data = $user->getUserData();
         $data->setVerify($params['text']);
         $data->save();
         return $user->getVerify();
     }
     else
     {
        $user->setFirstName($params['first_name']);
        $user->setLastName($params['last_name']);
        $user->setStreet($params['street']);
        $user->setPostCode($params['post_code']);
        $user->setCity($params['city']);
        $user->setCountry($params['country']);
        $user->setPhone($params['phone']);
        $user->setNip($params['nip']);
        $user->save();
        return $user->toArray(); 
     }
  	 
  }

  public function SmDeleteExecute(sfWebRequest $request, User $user)
  {
  	
  }

}
