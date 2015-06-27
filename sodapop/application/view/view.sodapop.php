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

class view {

	public $templatePath;
	public $loadTemplate;
	public $templateName;
	
	public	$template;	
	
	/*
	*   
	*/		
	public function view() {
	
	
	}

	public function displaySodapop($sodapop) {

	 	require_once $sodapop->template['path'] . "/index.php";
	
	}

}

?>