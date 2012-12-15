<?php

/**
 * mailing_list actions.
 *
 * @package    SystemCore
 * @subpackage mailing_list
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mailing_listActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    try
    {  
      if($request->isMethod('post'))          
      {
      	echo 'post mailing list';
      }           
      if($request->isMethod('put'))          
      {
      	echo 'post mailing list';
      }
    }
    catch(Exception $e)
    {
      echo $e->getMessage();
      exit;
    }
    return sfView::NONE;

  }
}
