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


class controllerPage extends application {

	public function controllerPage($databasePage) {

		// This is where all the action goes for the page, calling on functions also found in this class, and it's parent.
		
		$data['pageName']	= "Profile";  // building "data" aray to send to the view.
		
		$viewPage	= $this->loadView($data);  // this pulls in the view, and sends the "data" aray to it.

	}	
	
	public function someOtherStuff() {
	
	
	}	
}
?>