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
  }

  public function SmPostExecute(sfWebRequest $request, User $user)
  {
  	
  }

  public function SmPutExecute(sfWebRequest $request, User $user)
  {
  	
  }

  public function SmDeleteExecute(sfWebRequest $request, User $user)
  {
  	
  }

}
