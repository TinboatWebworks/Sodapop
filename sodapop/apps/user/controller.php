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


class appController extends sodapop {

	private $output;
	public $data;
	public $appModel;
	public $appView;
	
	public function appController($sodapop) {
	
		require_once $sodapop->pageData['filePath'] . "/model.php";
		$this->appModel	= new appModel;
		
		require_once $sodapop->pageData['filePath'] . "/view.php";		
		$this->appView	= new appView();
	}	
	
	public function loadApp($sodapop) {
	
		$this->config	= $sodapop->config;
		$this->appUrl	= $sodapop->appUrl;
		$this->urlVars	= $this->parseUrl('qString');
		$this->pageData	= $sodapop->pageData;
		$this->formData	= $this->getFormData($_POST);
		$this->redirect	= $sodapop->config['liveSite']; // Must chanage this to grab the redirect from the module params.

	}
	
	public function output($sodapop) {
	
		//Now we switch to the action based on the value of action
		//in the URL string
		switch ($this->urlVars['action']) {
	
			// If there is no string at all, we just attempt to log in	
			case '':
	
				$output	= $this->logIn($sodapop);
			
				break;
			
			// log out when action = logout
			case 'logout':
		
				$output	= $this->logOut($sodapop);
	
				break;
			
			// We want to create a new user, so this outputs the registration
			//form	
			case 'new':
		
				$output	= $this->newUser($sodapop);
	
				break;
				
			// There we are going to process the form and store the users data	
			case 'create':
		
				$output	= $this->createUser($sodapop);
	
				break;				
		}
		
	
		return $output;
		
	}
	
	/* 
	* 	logIn() processes the login data, determines if it's legit, and sets the cookie
	*  	if everythings is kosher.  Then redirects to the redirect URL as set in the Login
	* 	plugin.
	*/
	public function logIn($sodapop) {

		$checkPass			= $this->appModel->getPassword($this->formData['user']);
		$comparePass		= $this->comparePassword($this->formData['pass'], $checkPass);
				
		if ($comparePass == '1') {
		
			$this->processUser($this->formData['user']);	
		}
	
		elseif ($this->creatingUser == 1) {
	
	
			$this->processUser($this->formData['username']);
		}
		
		else { 

			$output = $sodapop->language['didNotPass'];
			$output = $output . $sodapop->language['thankYou'];

			return $output;
			
		}
	
	}
	
	public function processUser($name){

			$this->userData 	= $this->appModel->getUserData($name); 		
			$setCookie	= $this->setaCookie('sp_login', $this->userData['id'], 3600);
			header('Location: ' . $this->redirect);
	
	}
	
	/* 
	* 	logOut() deletes the cookie and redirects to the home page of the site 
	*/ 
	public function logout($sodapop)	{

		$setCookie	= $this->setaCookie('sp_login', $userData['id'], -3600);
//		$redirect		= $formData['redirect'];


		header('Location: ' . $this->redirect);
	
	}
	
	/* 
	* 	newUswer generates the form that to allow a new user to register and provides the
	*	form validation.
	*/
	public function newUser($sodapop)	{
		
		$output = $output . $sodapop->language['newUser'];
		
		$output = $output . $this->appView->buildRgstnForm();
		
		return $output;
	
	}
	
	/* 
	* createUser grabs the form data from newUser and pushes it to the database
	*/
	public function createUser($sodapop) {


		$confirmUnique	= $this->appModel->confirmUnique($this->formData);
	
		if ($confirmUnique !='1') {
			$this->appModel->putUserData($this->formData);
			$output = $output . "Creating your account!!!";
			$this->creatingUser	= "1";
			$this->login($sodapop);
		}
			
		else {$output = $output .  "email must be unique!";}						
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
	
	
	
}
?>