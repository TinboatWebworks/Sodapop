<?php

/**
* @author 	Brad Grochowski 
* @copyright	2011 Tinboat Webworks
* @version	0.0.1.2
* @link		a url
* @since  	10/20/2011
*/
 
// no direct access
defined('_LOCK') or die('Restricted access');

class login extends sodapop {

	public function login() {

	}

	public function loginOutput($loginDatabase, $modData) {
		
		$cookie		= $this->getCookie("sp_login");
		$redirect	= $modData['redirect'];


		if ($cookie == '') {
	
			$modOutput	= "
				
					<form name='login' action='http://localhost/~brad/git/Sodapop/sodapop/user' method='post'>
						Username: <input type='text' name='user'> 
						Password: <input type='text' name='pass'> 
						<input type='hidden' name='redirect' value='" . $redirect . "'>
						<input type='submit' value='Submit'>
						<a href='user?action=new'>Create Account</a>
					</form>";		
		}	
	
		else	{

	
			$userInfo	= $loginDatabase->getUserDataById($cookie);	
			$modOutput	= "You are logged in <b>" . $userInfo['name'] . "</b> [<a href='user?action=logout'>Log out</a>]";
	
		}

		return $modOutput;
	}
}