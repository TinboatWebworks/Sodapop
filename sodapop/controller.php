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
		$this->formData	= $this->getFormData($_POST);
		$this->pageData	= $sodapop->pageData;
		$this->redirect	= $this->sodapop->config['liveUrl']; // Maybe at some point this will be a app parameter
		
		if($this->formData['email'] != "") {
		
			$addBetaTester	= $this->appModel->addBetaTester($this->formData['email']);
			
			$emailData['message']	= $this->appView->buildEmail();
			$emailData['email']		= $this->formData['email'];
			$emailData['subject']  	= "Thank you for your interest in WatchWho.blue!";
			
			echo $emailData['body'];
			
			$this->sendEmail($emailData);
		
		}
		
		
	}
	
	public function output($sodapop) {	
	
		$output	= $this->appView->buildPage();
		
		return $output;
	}	
	
	
	
}
?>