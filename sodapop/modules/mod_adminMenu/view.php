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

class adminMenuView extends view {

	public function adminMenuView() {
		
	
	}
	
		public function displayAdminMenu() {
	
		$output = "	<div style='float: left; margin-left: 50px;'><strong>Manage: <a href='" . $this->sodapop->config['liveUrl'] . "modulemanager'>Modules</a> | <a href='" . $this->sodapop->config['liveUrl'] . "user?action=mangeusers'>Users</a></strong></div>";
					
		return $output;				
	
	}
}