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


## 	Load module controller
require_once $modulePath . "controller.php";
$menu	= new menu();

## 	Load module model
require_once $modulePath . "model.php";
$menuDatabase = new menuDatabase();

## 	Load module view
require_once $modulePath . "view.php";
$menuView	= new menuView();


?>
