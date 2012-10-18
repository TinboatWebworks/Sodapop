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

die('xxx');

## 	Load module controller
require_once "./controller.php";
$module 	= new module();

## 	Load module model
require_once "./model.php";
$moduleDatabase = new moduleDatabase();

## 	Load module view
require_once "./view.php";
$moduleView	= new moduleView();

## 	Load the template array
## $template		= $database->getDefaultTemplate();
