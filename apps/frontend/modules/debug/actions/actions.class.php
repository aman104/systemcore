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
    $user = UserTable::getInstance()->findOneByApiToken('f106798898ee9bd2d1d4d3d0144822');

    $mailings = MailingTable::getInstance()->getMailingsArrayByUser($user, 2);

    $mailing = $user->getMailingByHash('5558edd9');

    echo '<pre>';
    print_r($mailings);
    echo '</pre>';
    
  }
}
