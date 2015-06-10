<?php

/**
* @author 		Brad Grochowski 
* @copyright	2013 Tinboat Webworks
* @Project		Sodapop
* @version		0.0.1.3
* @link			http://tinboatwebworks.com
* @since  		10/20/2011
*/
 
// no direct access
defined('_LOCK') or die('Restricted access');

class login extends sodapop {

	public function login() {

	}

	public function loginOutput($loginDatabase, $modData) {
		
		$cookie		= $this->getCookie("sp_login");
		$redirect	= $modData['redirect'];
		global $sodapop;

		if ($cookie == '') {
	
			$modOutput	= "
					
					<form name='login' class='loginForm' action='./user?action=login' method='post'>
						Username: <input type='text' name='username'> 
						Password: <input type='password' name='pwd'> 
						<input type='hidden' name='redirect' value='" . $redirect . "'>
						<input type='submit' value='Submit'>";
						
			if ($modData['registration'] == "on") {			
						
					$modOutput	.= "	
						<a href='user?action=new'>[Register]</a>";
						
			}
			
			$modOutput	.= "			
					</form>";		
		}	
	
		else	{

	
			$userInfo	= $loginDatabase->getUserDataById($cookie);	
			$modOutput	= "You are logged in <b><a href='./user'>" . $userInfo['name'] . "</a></b> [<a href='./user?action=logout'>Log out</a>]";
	
		}

		return $modOutput;
	}
}