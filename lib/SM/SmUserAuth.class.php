<?php

class SmUserAuth {
	
	private static $request;

	public static function getUserAuthRequest(sfWebRequest $request)
	{
		self::$request = $request;

		$_get = self::$request->getGetParameters();
		$_post = self::$request->getPostParameters();

		

		$params = array_merge($_get, $_post);

		// echo '<pre>';
		// print_r($params);
		// echo '</pre>';
		// exit;

		$user = UserTable::getInstance()->findOneByApiToken($params['api_token']);

		if(self::checkCSRF($user, $params))
		{
			return $user;
		}
		else
		{
			throw new SmUserAuth_Exception('WRONG CSRF');
		}

		return $params;

	}

	public static function checkCSRF(User $user, $params)
	{
		$_csrf = self::generateCsrf($user, $params);
		return ($_csrf == $params['api_csrf']);
	}

	public static function generateCsrf(User $user, $params)
	{
		return md5($user->getApiToken().'.'.$user->getApiSecret());
	}

}

class SmUserAuth_Exception extends Exception 
{

}