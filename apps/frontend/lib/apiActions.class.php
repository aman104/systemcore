<?php

class ApiActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {    
    try
    {  

      $user = SmUserAuth::getUserAuthRequest($request);
      $params = SmUserAuth::getParamsRequest();
      $return = '';        

      switch($request->getMethod())
      {
        case 'POST' : 

          $return = $this->SmPostExecute($request, $user, $params);

          break;

        case 'PUT' : 

          $return = $this->SmPutExecute($request, $user, $params);

          break;

        case 'DELETE' : 

          $return = $this->SmDeleteExecute($request, $user, $params);

          break;

        default: 

          $return = $this->SmGetExecute($request, $user, $params);

      }

      echo json_encode($return);   
    }
    catch(Exception $e)
    {
      echo $e->getMessage();
      exit;
    }
    return sfView::NONE;

  }
}