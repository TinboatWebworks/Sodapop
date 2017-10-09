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
        
        $test = $sodapop->loadTest("user_model");
    }
    
    /*
     * getPassword() will retrieve the password of the given user
     */
    public function getPassword($user) {
        
        $query	= " select 	*
			from 	app_user_users
			where 	username = '$user'";
        
        $result	= $this->getData($query);
        
        while ($row= mysqli_fetch_array($result, MYSQL_ASSOC)) {
            
            $password	= $row['password'];
            
        }
        
        return $password;
        
        
    }
    
    /*
     * getPassword() will will pull all of the users data based on username from the db and pass it back as
     * an arrat, $userData
     */
    public function getUserData($username) {
        
        $query	= " select 	*
			from 	app_user_users
			where 	username = '$username'";
        
        $result	= $this->getData($query);
        
        while ($row= mysqli_fetch_array($result, MYSQL_ASSOC)) {
            
            
            $userData['id']				= $row['id'];
            $userData['name']			= $row['name'];
            $userData['email']			= $row['email'];
            $userData['username']		= $row['username'];
            $userData['accessLevel']	    = $row['accessLevel'];
        }
        
        return $userData;
        
    }
    
    
    /*
     * getUserDatafromEmail() will will pull all of the users data based on their email from the db and pass it back as
     * an arrat, $userData.  ##This can probably be refactored to be inlcuded in the getUserData() methode above.
     */
    public function getUserDatafromEmail($email) {
        
        $userData  = "";
        $query	= " select 	*
			from 	app_user_users
			where 	email = '$email'";
        
        $result	= $this->getData($query);
        
        while ($row= mysqli_fetch_array($result, MYSQL_ASSOC)) {
            
            
            $userData['id']				= $row['id'];
            $userData['name']			= $row['name'];
            $userData['email']			= $row['email'];
            $userData['username']		= $row['username'];
            $userData['accessLevel']	= $row['accessLevel'];
        }
        
        return $userData;
        
    }
    
    /*
     * confirmUnique() checks to make sure that the username and email are unigue when a user is
     * registering for a new account
     */
    public function confirmUnique($formData) {
        
        if (isset($formData['id'])) {
            
            $query	= " select 	email, username
	       			from app_user_users
		      		where id != " .  $formData['id'] . "";
        }
        
        else {
            $query=  " select 	email, username
	       			from app_user_users";
            
        }
        
        $result	= $this->getData($query);
        
        while ($row= mysqli_fetch_array($result, MYSQLI_ASSOC)) {
            
            $existingUser['email']		= $row['email'];
            $existingUser['username']	= $row['username'];
            
            if ($formData['email']  ==  $existingUser['email'] && $formData['username']  ==  $existingUser['username']) {
                
                $confirmUnique = 'no';
                
                return $confirmUnique;
            }
        }
        
        if (empty($confirmUnique)) {
            
            $confirmUnique	=	'yes';
            
            return $confirmUnique;
        }
        
        
    }
    
    /*
     * confirmUniqueUpdate() checks to make sure that the username and email are unigue when a user is
     * updating their account info.  ##This can probably be refactored to be inlcuded in the confirmUnique() methode above.
     */
    public function getUserDataForUnique($id) {
        
        $query	= " select 	email, username
					from app_user_users ";
        
        if ($id != '')	{
            
            $query .= "where id != '$id'";
        }
        
        $result	= $this->getData($query);
        
        $result	= $this->buildResultArray($result);
        
        return $result;
    }
    
    /*
     * putUserData() is going to push the users data to the db
     */
    public function putUserData($data) {
        
        $id				= "";
        $name			= $data['name'];
        $email			= $data['email'];
        $username		= $data['username'];
        $password		= $this->sodapop->hashIt($data['pwd']);
        $accessLevel  	= $data['accessLevel'];
        
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
    
    /*
     * deleteUserData() is going to delete the users data from the db
     */
    public function deleteUserData($id) {
        
        if (!$id) {
            $id		= $this->sodapop->getCookie("sp_login");
        }
        
        $query	= "	DELETE FROM app_user_users
					WHERE id	= '$id'";
        
        $result	= $this->getData($query);
        
        $return;
    }
    
    /*
     * updateUserData() is going to update the users data in the db
     */
    public function updateUserData($data) {
        //	    print_r($data);
        $unique		= $this->confirmUnique($data);
        $data		=	extract($data);
        
        if(isset($pwd)) { $pwd   = $this->sodapop->hashIt($pwd); }
        
        //		echo "pwd: " . $pwd; die();
        if(empty($output)) {$output = "";}
        
        if(isset($bio)){
            $bio = addslashes($bio);
        }
        
        // If it is, let's update the data
        if ( $unique == 'yes' ) {
            
            $query	= "	update app_user_users
						set";
            
            /*$query	.= 					" id		= '$id'";	*/
            
            $query	.= 					"";
            if(isset($name)) 			{ $query	.= " name		    = '$name'"; }
            if(isset($email)) 			{ $query	.= ", email		    = '$email'"; }
            if(isset($username)) 		{ $query	.= ", username	    = '$username'"; }
            if(isset($pwd)) 		        { $query	.= ", password	    = '$pwd'"; }
            if(isset($bio)) 				{ $query	.= ", bio			= '$bio'"; }
            if(isset($accessLevel)) 		{ $query	.= ", accessLevel	= '$accessLevel'"; }
            if(isset($token)) 	        { $query	.= ", recoveryToken	= '$token'"; }
            
            $query	.= " where	id			= '$id'";
            
            $result	= $this->getData($query);
        }
        
        // If it's not, let's let them know
        else {
            
            $output = $unique;
        }
        
        // Check to see if we are updating the password.
        if ($data['pwd'] != '') {
            
            // If we are, let's hash the password
            $password		= $this->sodapop->hashIt($data['pwd']);
            
            $query	= "update app_user_users
						set 	password	= '$password'
						
						where	id			= '$id'";
            
            $result	= $this->getData($query);
        }
        
        return $output;
    }
    
    
    /*
     * checkForToken() We use this to check if there is a password recovery token during the
     * password recovery process
     */
    public function checkForToken($token) {
        
        $id    ="";
        
        $query = "	select	*
					from	app_user_users
					where	recoveryToken = '" . $token . "'";
        
        $result	= $this->getData($query);
        
        while ($row= mysqli_fetch_array($result, MYSQL_ASSOC)) {
            
            $id	= $row['id'];
            
        }
        
        return $id;
    }
    
    /*
     * updateNewPassword() Updates the password field.
     */
    public function updateNewPassword ($data) {
        
        $token		= $data['token'];
        $password	= $data['password'];
        $emptyToken	= $data['emptyToken'];
        
        $query	= "		update app_user_users
						set
						password		= '" . $password  . "',
						recoveryToken	= '" . $emptyToken  . "'
						    
						where
						recoveryToken		= '" . $token  . "'";
        
        $result	= $this->getData($query);
        
        $output	= $this->sodapop->language['passwordUpdated'];
        
        return $output;
        
    }
    
    /*
     * userListData()
     */
    public function userListData() {
        
        $query	= " select 		*
					from 		app_user_users
					order       by	id";
        
        $result	= $this->getData($query);
        
        $result	= $this->buildResultArray($result);
        
        return $result;
        
    }
    
}