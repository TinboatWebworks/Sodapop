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


## 	Load module controller
require_once $modulePath . "controller.php";
$menu	= new menu();

## 	Load module model
require_once $modulePath . "model.php";
$menuDatabase = new loginDatabase();

## 	Load module view
require_once $modulePath . "view.php";
$menuView	= new loginView();


?>