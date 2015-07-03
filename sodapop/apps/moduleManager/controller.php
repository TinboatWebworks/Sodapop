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

		$this->config	= $this->database->config;
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
	
			case '':
	
				$output	= $this->firsttext();
			
				break;
			
			case 'updateStatus':
		
				$output	= $this->updateStatus();
	
				break;

			case 'updateAccess':
		
				$output	= $this->updateAccess();
	
				break;
				
			case 'updatePages':

				$output	= $this->updatePages();
	
				break;	
				
			case 'updateHidden':

				$output	= $this->updateHidden();
	
				break;								
				
		}
		
	
		return $output;
		
	}
	
	public function firsttext() {
	
		$modulesData= $this->appModel->getModuleData();	

		$moduleList	= $this->appView->buildModuleList($modulesData);

		$output		= $this->appView->listModules($moduleList);
	
		return $output;	
	}
	
	public function updatePages() {
		
		$values	= $this->sodapop->newGetStringVariables();
		
		$output	= $this->appModel->updatePages($values);

		$output	.= $this->firsttext();
	
		return $output;	
	}
	
	public function updateHidden() {
		
		$values	= $this->sodapop->newGetStringVariables();
		
		$output	= $this->appModel->updateHidden($values);

		$output	.= $this->firsttext();
	
		return $output;	
	}	
	
	public function updateStatus() {

		$output	= $this->appModel->switchStatus($this->urlVars);

		$output	= "update";
		$output	= $this->firsttext();
	
		return $output;	
	}
		
	public function updateAccess() {
	
		$output	= $this->appModel->updateAccessLevel($this->urlVars);

		$output	= $this->firsttext();
	
		return $output;	
	}			
}
?>