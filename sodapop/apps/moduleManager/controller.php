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
			case '':
	
				$output	= $this->firsttext();
			
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
				
		}
		
	
		return $output;
		
	}
	
	public function firsttext() {
	
		$moduleList	= $this->appModel->buildModuleList();
		$output	= $this->appView->listModules($moduleList);
	
		return $output;	
	}
			
}
?>