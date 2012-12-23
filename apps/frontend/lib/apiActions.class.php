<?php

class ApiActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    try
    {  

      $user = SmUserAuth::getUserAuthRequest($request);
      $return = '';    

      switch($request->getMethod())
      {
        case 'POST' : 

          $return = $this->SmPostExecute($request, $user);

          break;

        case 'PUT' : 

          $return = $this->SmPutExecute($request, $user);

          break;

        case 'DELETE' : 

          $return = $this->SmDeleteExecute($request, $user);

          break;

        default: 

          $return = $this->SmGetExecute($request, $user);

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