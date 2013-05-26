<?php

/**
 * payment actions.
 *
 * @package    SystemCore
 * @subpackage payment
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class paymentActions extends ApiActions
{

  public function SmPostExecute(sfWebRequest $request, User $user)
  {
      $params = array();
      $params = $request->getPostParameters();
      $payment = $user->addPayment($params['points']);
      $return = $payment->toArray();      
      return $return;
  }

  public function SmGetExecute(sfWebRequest $request, User $user)
  {

    $hash = $request->getParameter('hash');
    $method = $request->getParameter('method');
    
    if(isset($method) && $method == 'download')
    {        
        $payment = PaymentTable::getInstance()->findOneByHash($hash);
        $return = Tools::abs_url_for('download_invoice', $payment);
    }
    else
    {
        $return = $user->getPayment()->toArray();
    }
  	
  	return $return;
  }
}
