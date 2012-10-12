<?php


/**
* @author 	Brad Grochowski 
* @copyright	2011 Tinboat Webworks
* @version	0.0.1.2
* @link		a url
* @since  	10/20/2011
*/
 

define('_LOCK', 1 );

## bootstrap and load application

require_once "./utilities/loader.php";

## begin action ###

require_once $template['path'] . "/index.php";

?>