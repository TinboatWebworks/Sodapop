<?php

/**
* @author 	Brad Grochowski 
* @copyright	2011 Tinboat Webworks
* @version	0.0.1.1
* @link		a url
* @since  	10/20/2011
*/
 
// no direct access
defined('_LOCK') or die('Restricted access');

class viewPage extends view {

	public function viewPage($data) {

	global $language;	

		echo $language['whatPage'] . $data['pageName'];
	}
	
}
?>