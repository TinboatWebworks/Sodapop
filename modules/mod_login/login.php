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

$modulePath	= "./modules/mod_" . $modData['name'] . "/";
global $config;

## bootstrap and load the module
require $modulePath . "utilities/loader.php";

$modOutput	= $login->loginOutput($loginDatabase, 
$modData);  

## Load template ##
 
require $modulePath . "template/index.php";

?>