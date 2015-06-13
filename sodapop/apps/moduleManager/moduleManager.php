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
		
		require_once $this->pageData['filePath'] . "/controller.php";
		$appController	= new appController($this);
		$appController->loadApp($this);