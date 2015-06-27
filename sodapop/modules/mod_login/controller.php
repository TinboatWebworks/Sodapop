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
	
		global $sodapop; // Let's bring in the global app object so we can access all the environmental info...
		$this->sodapop	= $sodapop; // And give it to this class

	}

	public function loginOutput($loginDatabase, $modData) {
		
		$cookie		= $this->getCookie("sp_login");
		$redirect	= $modData['redirect'];
		global $sodapop;
		$this->sodapop;

		if ($cookie == '') {
			
			$liveUrl	= $sodapop->config['liveUrl'];

			$modOutput	= "
					
					<form name='login' class='loginForm' action='./user?action=login' method='post'>
						Username: <input type='text' name='username'> 
						Password: <input type='password' name='pwd'> 
						<input type='hidden' name='redirect' value='" . $liveUrl . $redirect . "'>
						<input type='submit' value='Submit'>";
						
			if ($modData['registration'] == "on") {			
						
					$modOutput	.= "	
						<a href='user?action=new'>[Register]</a>";
						
			}

			if ($modData['recover'] == "on") {			
						
			$modOutput	.= "	
						<a href='user?action=recover'>[Recover]</a>";
						
			}
			
			$modOutput	.= "			
					</form>";		
		}	
	
		else	{

			$userInfo	= $this->sodapop->getUserDataById($cookie);	
			$modOutput	= "You are logged in as <b><a href='./user'>" . $userInfo['name'] . "</a></b> [<a href='./user?action=logout'>Log out</a>]";
	
		}

		return $modOutput;
	}
}