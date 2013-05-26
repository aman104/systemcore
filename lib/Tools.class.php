<?php

use Zend\Mail;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;

class Tools
{

	static function sendEmail($to, $title, $content, $from = array('name' => 'SystemCore', 'email' => 'system@core.pl'), $text = false)
	{
        $text = new MimePart($text);
        $text->type = "text/plain";

        $html = new MimePart($content);
        $html->type = "text/html";

        $body = new MimeMessage();
        $body->setParts(array($text, $html));

        $mail = new Mail\Message();
        $mail->setBody($body);
        $mail->setFrom($from['email'], $from['name']);
        $mail->addTo($to);
        $mail->setSubject($title);

        $transport = new Mail\Transport\Sendmail();
        $transport->send($mail);
        
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

    static function getPrice($valueAsIs)
    {

      $value = ((double)$valueAsIs/100);
      $stats = explode('.',$value);
      if(isset($stats[1]))
      {
          $return = (strlen($stats[1])==1) ? $stats[0].'.'.$stats[1].'0' : $stats[0].'.'.$stats[1];
      }
      else
      {
          $return = $stats[0].'.00';
      }

      return $return;

    }


}