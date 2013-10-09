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

	public function deleteUserData($id) {
	
		if (!$id) {
			$id		= $this->sodapop->getCookie("sp_login");
		}
		
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
		$accessLevel	= $data['accessLevel'];
		$bio			= addslashes($data['bio']);
		
		$unique	= $this->confirmUniqueUpdate($data);
	
		if ( $unique == 'yes' ) {
		
			$query	= "	update app_user_users
						set";
			
			$query	.= " id		= '$id'";			
			if($name != '') 		{ $query	.= ", name		= '$name'"; }
			if($email != '') 		{ $query	.= ", email		= '$email'"; } 
			if($username != '') 	{ $query	.= ", username	= '$username'"; }
			if($bio != '') 			{ $query	.= ", bio			= '$bio'"; }
			if($accessLevel != '') 	{ $query	.= ", accessLevel	= '$accessLevel'"; }    
						
			$query	.= " where	id			= '$id'";
//die ($query);										
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
	
	public function buildUserList() {

		$query	= " select 		*
					from 		app_user_users
					order by	id";			
	
		$result	= $this->getData($query);
		
		while ($row= mysql_fetch_array($result, MYSQL_ASSOC)) {
				
				$id				= $row['id'];
				$name			= $row['name'];
				$email			= $row['email'];
				$userName		= $row['username'];	
				$accessLevel	= $row['accessLevel'];	
				
				$userList	.="<form name='Manage' onsubmit='return validateFormOnSubmitmanageUsers(this)' action='" . $this->sodapop->config['liveUrl'] . "user?action=mangeusers&do=update' method='post'>";
				$userList	.="<tr>";
				$userList	.="<td>" .$id . "</td>";
				$userList	.="<td><input type='text' name='name' value='" . $name . "'></td>";
				$userList	.="<td><input type='text' name='email' value='" . $email . "'></td>";
				$userList	.="<td><input type='text' name='username' value='" . $userName . "'></td>";
				$userList	.="<td><input type='text' name='pwd' value=''></td>";
				$userList	.="<td><select name='accessLevel'><option>" . $accessLevel . "</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>11</option></td>";
				$userList	.="<td><input name='id' type='hidden' value='" .$id . "'><input name='Submit' type='submit' value='Update'></form></td>";
				$userList	.="<form name='Delete' action='" . $this->sodapop->config['liveUrl'] . "user?action=mangeusers&do=delete' method='post'>";
				$userList	.="<td><input name='id' type='hidden' value='" .$id . "'><input name='Submit' type='submit' value='Delete'></form></td>";				
				$userList	.="</tr>";	
				$userList	.="";														
			}

		return $userList;	
	
	}

}