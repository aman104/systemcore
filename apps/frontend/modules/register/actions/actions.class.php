<?php

/**
 * register actions.
 *
 * @package    SystemCore
 * @subpackage register
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class registerActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
 	if($request->isMethod('post'))
 	{
 		$params = $request->getPostParameters(); 		
 		$return = UserTable::getInstance()->createFromParams($params);
 		echo json_encode($return->returnToArray());  
 	}
  }
}
