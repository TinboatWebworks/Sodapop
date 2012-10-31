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

class viewApp extends view {

	public $language;
	public $data;
	
	public function viewApp($data) {

	global $language;	

		echo $language['whatApp'] . $data['appName'];
	}
	
}
?>