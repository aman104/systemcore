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
    $user = UserTable::getInstance()->find(1);
    $return1 = MailingTable::getInstance()->getMailingsArrayByUser($user, 3);
    $return2 = MailingTable::getInstance()->getMailingsArrayByUser($user, 3);
    $return3 = MailingTable::getInstance()->getMailingsArrayByUser($user, 3);

    echo count($return1).'<br />';
    echo count($return2).'<br />';
    echo count($return3).'<br />';


    exit;


    
  }
}
