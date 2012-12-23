<?php

class Tools
{

	static function sendEmail($to, $title, $content, $from = 'system@core.pl')
	{
		$headers = '';
    	$headers  .= 'MIME-Version: 1.0' . "\r\n";
    	$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    	$headers .= "From: ". $from . " <" . $from . ">\r\n";
    	ini_set('sendmail_from', $from);
    	mail($to, $title, $content, $headers);
	}

	static function genUniqueHash($length = NULL){        
        $id = uniqid(hash("sha512",rand()), TRUE);
        $code = hash("sha512", md5( uniqid(php_uname('n'), true) ));
        return substr($code, 0, $length);
    }

	static public function url_for($route,$object = null)
    {
        if($object == null)
        {
            return sfContext::getInstance()->getController()->genUrl($route , $absolute = false );
        }
        else
        {
            return sfContext::getInstance()->getController()->genUrl( array(
                'sf_route' => $route,
                'sf_subject' => $object
            ));
        }
    }

    static public function abs_url_for($route, $object = null, $lang = null)
    {
      if ($lang) {
        sfContext::getInstance()->getUser()->setCulture($lang);
      }

      $url = self::url_for($route, $object);

      if ($lang) {
        sfContext::getInstance()->getUser()->setCulture(Lang::getDefaultLanguage());
      }

      return self::getSiteNameUrl() . $url;
    }

    static public function getFQDN()
    {
        $parts = array();
        $parts = explode('.',$_SERVER['SERVER_NAME'],2);
        if(($parts[0] == 'www') || ($parts[0] == 'admin'))
        {
            return $parts[1];
        }
        else
        {
            return $_SERVER['SERVER_NAME'];
        }
    }

    static public function getSiteNameUrl()
    {
            return 'http://'.self::getFQDN();
    }



}