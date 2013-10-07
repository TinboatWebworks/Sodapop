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
			
			case 'edit':
		
				$output	= $this->editProfile();
	
				break;	

			case 'update':
		
				$this->	output	= $this->updateProfile();
	
				break;		
				
			case 'delete':
		
				$this->	output	= $this->deleteUser();
	
				break;								
			
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
	* deleteUser 
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
	
	public function showProfile()  {
	
		$output = $this->appView->buildProfile($this->sodapop);
	
		return $output;
	}
	
	public function editProfile()  {
	
		$output = $this->appView->buildEditProfile($this->sodapop);
	
		return $output;
	}	
	
		public function updateProfile()  {

		$output = $this->appModel->updateUserData($this->formData);	
	
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
}
?>