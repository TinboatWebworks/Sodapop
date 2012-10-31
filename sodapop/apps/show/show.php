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

		$appFilePath	=  "./apps/" . $pageData['getApp'];
		
		require_once $appFilePath . "/controller.php";
		require_once $appFilePath . "/model.php";		
		
		// Create the model object for this page
		$databaseApp		= new databaseApp(); 
		
		// Create the Controller for the page and sent the Model Object into it		
		$controllerApp = new controllerApp($databasePage); 
		
?>