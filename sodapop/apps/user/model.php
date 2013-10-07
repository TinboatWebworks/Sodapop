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
	
		global $sodapop; // Let's bring in the global app object so we can access all the environmental info...
		$this->sodapop	= $sodapop; // And give it to this class
	
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
			
				$confirmUnique = 'no';							
			}
			
		}
		
		if ($confirmUnique != 'no'){
	
			$confirmUnique	=	'yes';
		}
					
		return $confirmUnique;
	}	
	
	public function confirmUniqueUpdate($formData) {

		$id		= $formData['id'];

		$query	= " select 	email, username
					from app_user_users ";	
					
		if ($id != '')	{
			
			$query .= "where id != '$id'";
		}							
	
		$result	= $this->getData($query);
		
		while ($row= mysql_fetch_array($result, MYSQL_ASSOC)) {
	
			$existingUser['email']		= $row['email'];
			$existingUser['username']	= $row['username'];
		
		
			if (($formData['email']  ==  $existingUser['email']) || ($formData['username']  ==  $existingUser['username'])) {
		
				if ($formData['email']  ==  $existingUser['email']) { 
		
					$confirmUnique['email'] = "email";
							
				}	
			
				if ($formData['username']  ==  $existingUser['username']) {
	
					$confirmUnique['username'] = "username";
					
						
				}			
			}		

		}	
		
		if ($confirmUnique == ''){
			
			$confirmUnique	=	'yes';
		}

		return $confirmUnique;		
	}
	
	public function putUserData($data) {
	 
		$id				= "";
		$name			= $data['name'];
		$email			= $data['email'];
		$username		= $data['username'];
		$password		= $this->sodapop->hashIt($data['pwd']);
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

	public function deleteUserData() {
	
		$id		= $this->sodapop->getCookie("sp_login");
	
		$query	= "	DELETE FROM app_user_users 
					WHERE id	= '$id'";
		
		$result	= $this->getData($query);
		
		$return;				
	}
	
	public function updateUserData($data) {
 
 		$id				= $data['id'];
		$name			= $data['name'];
		$email			= $data['email'];
		$username		= $data['username'];
		$bio			= addslashes($data['bio']);
		
		$unique	= $this->confirmUniqueUpdate($data);
	
		if ( $unique == 'yes' ) {
		
			$query	= "	update app_user_users
						set 	name		= '$name', 
								email		= '$email', 
								username	= '$username',
								bio			= '$bio'
						
						where	id			= '$id'";
										
			$result	= $this->getData($query);		
		}
		
		else {
	
			$output = $unique;							
		}
		
		if ($data['pwd'] != '') {
	
			$password		= $this->sodapop->hashIt($data['pwd']);
		
			$query	= "update app_user_users
						set 	password	= '$password'
					
						where	id			= '$id'";	
			
			$result	= $this->getData($query);																		
		}

		return $output;			
	}	

}