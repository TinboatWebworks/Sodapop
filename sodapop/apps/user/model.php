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
//die($password);
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
	
	public function confirmUnique($formData) {

		$query	= " select 	email, username
					from app_user_users";						
	
		$result	= $this->getData($query);
		
		while ($row= mysql_fetch_array($result, MYSQL_ASSOC)) {
	
			$existingUser['email']		= $row['email'];
			$existingUser['username']	= $row['username'];
				
			if ($formData['email']  ==  $existingUser['email'] || $formData['username']  ==  $existingUser['username']) {
		
				$confirmUnique = 1;				

				return $confirmUnique;
			
			}
			
			else { $confirmUnique = '2'; }
		}
		


		return $confirmUnique;		
	}
	
	public function putUserData($data) {

		global $sodapop;  // Is there really no better way to get to the hashIt method?  Argh.
	 
		$id				= "";
		$name			= $data['name'];
		$email			= $data['email'];
		$username		= $data['username'];
		$password		= $sodapop->hashIt($data['pwd']);
		$accessLevel	= '5';

		$query	= "insert into app_user_users
							( 	name, 
								email, 
								username,
								password, 
								accessLevel)

					values 	(	'$name', 
								'$email', 
								'$username',
								'$password', 
								'$accessLevel')";								
		$result	= $this->getData($query);
		return $result;			
	}

}