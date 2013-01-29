<?php

/**
 * debug actions.
 *
 * @package    SystemCore
 * @subpackage debug
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class debugActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $mailing = MailingTable::getInstance()->find(1);

    //$mailing->run();

    print_r($mailing->getMailingLinks()->toArray());

    
  }
}
