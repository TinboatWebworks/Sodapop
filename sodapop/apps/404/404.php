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

		$pageFilePath	=  "./pages/" . $pageData['getPage'];
		
		require_once $pageFilePath . "/controller.php";
		require_once $pageFilePath . "/model.php";		
		
		// Create the model object for this page
		$databasePage		= new databasePage(); 
		
		// Create the Controller for the page and sent the Model Object into it		
		$controllerPage = new controllerPage($databasePage); 
		
?>