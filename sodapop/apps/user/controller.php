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


class appController extends sodapop {

	private $output;
	public $data;
	public $appModel;
	public $appView;
	
	public function appController() {
	
		global $sodapop; // Let's bring in the global app object so we can access all the environmental info...
		$this->sodapop	= $sodapop; // And give it to this class
	
		require_once $this->sodapop->pageData['filePath'] . "/model.php";
		$this->appModel	= new appModel;
		
		require_once $this->sodapop->pageData['filePath'] . "/view.php";		
		$this->appView	= new appView();
		
	}	
	
	public function loadApp() {
	
		$this->config	= $this->sodapop->config;
		$this->appUrl	= $this->sodapop->appUrl;
		$this->urlVars	= $this->sodapop->parseUrl('qString');
		$this->pageData	= $this->sodapop->pageData;
		$this->formData	= $this->getFormData($_POST);
		$this->redirect	= $this->sodapop->config['liveUrl']; // Maybe at some point this will be a app parameter

	}
	
	public function output() {
	
		//Now we switch to the action based on the value of action
		//in the URL string
		switch ($this->urlVars['action']) {
	
			// If there is no string at all, we just attempt to log in	
			case 'login':
	
				$output	= $this->logIn();
			
				break;
			
			// log out when action = logout
			case 'logout':
		
				$output	= $this->logOut();
	
				break;
			
			// We want to create a new user, so this outputs the registration
			//form	
			case 'new':
		
				$output	= $this->newUser();
	
				break;
				
			// There we are going to process the form and store the users data	
			case 'create':
		
				$output	= $this->createUser();
	
				break;	
			
			// If we want to edit our profile
			case 'edit':
		
				$output	= $this->editProfile();
	
				break;	

			// updating profiles from user management list
			case 'update':
		
				$output	= $this->updateProfile();
	
				break;		
			
			// Start the process of recovering a lost password	
			case 'recover':
		
				$output	= $this->recoverPassword();
	
				break;	
				
			// Ask for the token in password recovery process	
			case 'tokenplease':
		
				$output	= $this->dealWithToken();
	
				break;							

			// Check the token and ask for a new password during password recovery	
			case 'checktoken':
		
				$output	= $this->checkToken();
	
				break;		
				
			// Update the password during password recovery	
			case 'updatePassword':
		
				$output	= $this->updatePassword();
	
				break;						
				
			// Delete a use from the user manager list	
			case 'delete':
		
				$output	= $this->deleteUser();
	
				break;		

			// Loads the user manager page
			case 'mangeusers':
		
				$output	= $this->manageUsers();
	
				break;											
			
			// just show the logged-in users provile
			case '':
		
				$output	= $this->showProfile();
	
				break;					
		}
		
	
		return $output;
		
	}
	
	/* 
	* 	logIn() processes the login data, determines if it's legit, and sets the cookie
	*  	if everythings is kosher.  Then redirects to the redirect URL as set in the Login
	* 	plugin.
	*/
	public function logIn() {

		$checkPass			= $this->appModel->getPassword($this->formData['username']);
		$comparePass		= $this->comparePassword($this->formData['pwd'], $checkPass);

		if ($comparePass == '1') {
		
			$this->processUser($this->formData['username']);	
		}
	
		elseif ($this->creatingUser == 1) {
	
	
			$this->processUser($this->formData['username']);
		}
		
		else { 

			$output = $this->sodapop->language['didNotPass'];
			$output = $output . $this->sodapop->language['thankYou'];

			return $output;
			
		}
	
	}

	/* 
	* 	processUser() Pushes the user's data to the database, sets the cookie
	*/ 	
	public function processUser($name){

			$this->userData 	= $this->appModel->getUserData($name); 		
			$setCookie	= $this->setaCookie('sp_login', $this->userData['id'], 3600);
			header('Location: ' . $this->formData['redirect']);
	
	}
	
	/* 
	* 	logOut() deletes the cookie and redirects to the home page of the site 
	*/ 
	public function logout()	{

		$setCookie	= $this->setaCookie('sp_login', $userData['id'], -3600);

		header('Location: ' . $this->redirect);
	
	}
	
	/* 
	* 	newUswer generates the form that to allow a new user to register and provides the
	*	form validation.
	*/
	public function newUser()	{
		
		$output = $output . $this->sodapop->language['newUser'];
		
		$output = $output . $this->appView->buildRgstnForm($this->sodapop);
		
		return $output;
	
	}
	
	/* 
	* deleteUser will allow a logged-in user to delete their own profile.
	*/
	public function deleteUser() {

		$this->appModel->deleteUserData();
		$this->logout();

	}
	
	public function createUser() {

		$confirmUnique	= $this->appModel->confirmUnique($this->formData);

		if ($confirmUnique == 'yes') {
			$this->appModel->putUserData($this->formData);
			$output = $output . "Creating your account!!!";
			$this->creatingUser	= "1";
			$this->login();
		}
			
		else {$output = $output .  "email and username must be unique!";}						
		return $output;
	
	}
	
	/*
	* Compare password makes sure that the password provided on login matches the users
	* password in the database.
	*/
	public function comparePassword($password, $checkPass) {
	
		$password	= $this->hashIt($password);
		
		if ($password == $checkPass) {
		
			$match	= "1";
		
		}

		return $match;
	}	

	/*
	* showProfile() shows current user's profile
	*/		
	public function showProfile()  {
	
		$output = $this->appView->buildProfile();
	
		return $output;
	}


	/*
	* editProfile() shows the form for the user to edit their profile
	*/			
	public function editProfile()  {
	
		$output = $this->appView->buildEditProfile();
	
		return $output;
	}	
	
	
	/*
	* updateProfile() Is going to update the user's profile
	*/		
	public function updateProfile()  {

		$output = $this->appModel->updateUserData($this->formData);	
	
		//If there is form data
		if ($output) { 
		

			$string = "update=nope";		

			if($output['email'] == 'email') 	{ $string .= "&dupEmail=1"; }
			if($output['username']  == 'username')	{ $string .= "&dupName=1"; }	

			header('Location: ' . $this->sodapop->config['liveUrl'] . 'user?action=edit&' . $string);
		}
		
		else {
			header('Location: ' . $this->sodapop->config['liveUrl'] . 'user');
		}	
	}	
	
	/******************************
	* PASSWORD RECOVERY
	******************************/	
	
	/*
	* recoverPassword() Is going to present the form to get the password recovery process rolling.
	*/		
	public function recoverPassword()  {


		$recoverEmail = $this->formData['recoveryEmail'];
		
		
		if (!$step) {
		
		echo $step;
		
			$output .= $this->appView->buildRecoverPassword();
		
		}
		
		return $output;

	}		
	
	
	/*
	* dealWithToken() Is going to generate the token and email it.  Then it's going to 
	* ask the user for the token
	*/		
	public function dealWithToken()  {

		// get the variables from the form data
		extract($this->formData);
	
		// First lets see if we were sent here by the recovery form.  If we were
		// we need to generate the token, post it to the db, and send out the email.
		if ($sendToken == "yes") {

			// Make sure there is a matching user
			$userData = $this->appModel->getUserDatafromEmail($recoveryEmail);
			
			if (!$userData)	{
				
				// If there isn't a matching user, we'll let them know
				$output .= $this->sodapop->language['NoMatchingAccount'] . "<br />";
				
				// then let them try again
				$output .= $this->appView->buildRecoverPassword();
				
				return $output;
			
			}
		
			// If there is a matching user, lets generate the token
			$userData[token] = $this->sodapop->randomizedString(32);
									
			// Then stick the token in the database				
			$output 		.= $this->appModel->updateUserData($userData);	
			
			// And email the token to the user's email address
			$output 		.= $this->emailToken($userData);
			$output			.= "<span style='color:gray; font-size:10px; font-family:courier;'>" . $userData[token] . "</span>";
		
		}
		
		// Ask the user for the token
		$output .= $this->appView->buildAskForToken();
		
		return $output;

	}		
	
	/*
	* checkToken() is going to compare the token to the database to see if there is a match.  
	* If there is we will go ahead and ask the user for their new password.
	*/ 
	public function checkToken()  {
	
		//Extract form data to get the token from the form data from the form in the previous step
		extract($this->formData);		
		
		// Check db to make sure token exists
		if ($token) {
			// and get the user's id if it does
			$id	= $this->appModel->checkForToken($token);
		}
		
		// If we couldn't find a matching token, let them know and...
		if (!$id) {
		
			$output = "Invalid token.";
			
			// ...allow them to try again
			$output .= $this->appView->buildAskForToken();
			
			return $output;
		
		}
		
		// if we do have a matching token, then let's ask then for their new password
		if ($id) {
		
			// offer form to input new password
			$output	.= $this->appView->askForNewPassword($token);
			
			// Still need to validate form
	
		}
	
		return $output;
	
	}
	
	
	/*
	* updatePassword() is going to push the new password to the database and let them know 
	* we're all done.
	*/
	public function updatePassword() {
	
		$data['token'] 			= $this->formData['token'];
		$data['password']	 	= $this->sodapop->hashit($this->formData['pwd']);
		$data['emptyToken']		= "";
	
		if($data['token']) {

  			// Let's let them know we've updated their password and invite them to log in	
			$output	= $this->sodapop->language[updatingPasswordMessage];
		
			// And send their new password to the database.
			$output	.= $this->appModel->updateNewPassword($data);		

		}

		// Uh oh... are they hitting the page without going through the password recovery process?  Tell them nope.
		else {
		
			$output	= $this->sodapop->language['youDontHaveAToken'];		
		}
		
		return $output;
	
	}
	
	/*
	* emailToken() assembles the data to send to the email function which will send it out to the user
	*/
	public function emailToken($data) {
	
	
	
		$emailData['email']		= $data['email'];
		$emailData['subject']	= "Your Password Token from " . $this->sodapop->config['siteName'];
		$emailData['message']	= "You have requested a token to reset your password at " . $this->sodapop->config['siteName'] . ".\n
									Your token is: " . $data['token'] . "\n
									You can submit this token to reset your password at: 
									" .  $this->sodapop->config['liveUrl'] . ".user?action=tokenplease \n
									\n
									Thanks much!\n
									\n
									The staff of " . $this->sodapop->config['siteName'];
		
		$this->sodapop->sendEmail($emailData);
			
	}	
	
	
	/******************************
	* MANAGE USERS
	******************************/
	

	/*
	* manageUsers() outputs a list of all users, and allows admins to manage them
	*/		
	public function manageUsers()  {


		// Are we updating edited user data?  If so, lets push the new data to the db
		if($this->urlVars['do'] == 'update') {

			$this->appModel->updateUserData($this->formData);
		
		}
		
		// Are we adding a new user?  Let's send this new users data to the db
		if($this->urlVars['do'] == 'new') {

			//Make sure the user is unique.
			$confirmUnique	= $this->appModel->confirmUnique($this->formData);

			//and if it is, update the db
			if ($confirmUnique == 'yes') {
				$this->appModel->putUserData($this->formData);
			}			
		}

		//Are we deleting a user?
		if($this->urlVars['do'] == 'delete') {

			// Remove their data from the db
			$this->appModel->deleteUserData($this->formData['id']);
		
		}

		//Get their id to make sure they are allowed to manage user data (must have an access 
		//of 5 or greater
		$id = $this->sodapop->getCookie("sp_login");

		//If they are greater than level 5, show them the list
		if ($this->appModel->checkAccessLevel($id) >= 5) {

			$userList	= $this->appModel->buildUserList();
			$output = $this->appView->listUsers($userList);
		}
		
		// But if they aren't they can't come in.
		else { $output = $this->sodapop->language['cannotView']; }
			
		return $output;
	}	
	
}
?>