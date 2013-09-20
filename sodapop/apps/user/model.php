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

class appModel extends database {

	public function appModel() {
	
	}


	public function getPassword($user) {

			$query	= " select 	*
			from 	app_user_users
			where 	username = '$user'";
	
		$result	= $this->getData($query);
		
			while ($row= mysql_fetch_array($result, MYSQL_ASSOC)) {
				
				$password	= $row['password'];
													
			}

		return $password;
	
	
	}
	
	public function getUserData($username) {

		$query	= " select 	*
			from 	app_user_users
			where 	username = '$username'";			
	
		$result	= $this->getData($query);
		
		while ($row= mysql_fetch_array($result, MYSQL_ASSOC)) {

				
				$userData['id']				= $row['id'];
				$userData['name']			= $row['name'];
				$userData['email']			= $row['email'];
				$userData['username']		= $row['username'];	
				$userData['accessLevel']	= $row['accessLevel'];											
			}

		return $userData;	
	
	}
	
	public function createUser($data) {

		$query	= "";
	}

}