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

$modulePath	= "./modules/mod_" . $modData['name'] . "/";
global $config;

## bootstrap and load the module
require $modulePath . "utilities/loader.php";

$modOutput	= $login->loginOutput($loginDatabase, $modData);  

## Load template ##
 
require $modulePath . "template/index.php";

?>