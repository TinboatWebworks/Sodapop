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

	private $appOutput;
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
	}
	
	public function appOutput($sodapop) {	
	
		$appOutput = $sodapop->language['whatApp'] . $this->pageData['getApp'] ;
		return $appOutput;
	}	
	
	
	
}
?>