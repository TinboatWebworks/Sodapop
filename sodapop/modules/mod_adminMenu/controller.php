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


class adminMenu extends sodapop {

	public function adminMenu() {
	
		global $sodapop; // Let's bring in the global app object so we can access all the environmental info...
		$this->sodapop	= $sodapop; // And give it to this class
	
		require_once $this->sodapop->config['sitePath'] . "modules/mod_adminMenu/model.php";
		$this->adminMenuDatabase	= new adminMenuDatabase;
		
		require_once $this->sodapop->config['sitePath'] . "modules/mod_adminMenu//view.php";		
		$this->adminMenuView	= new adminMenuView();

	}

	public function adminMenuOutput() {
		
			//Check their uers level to see how much access they have
			$id = $this->sodapop->getCookie("sp_login");
	
			//Allow them to manage users if their user level is greater than 5
			if ($this->sodapop->checkAccessLevel($id) >= 5) {
				$output	= $this->adminMenuView->displayAdminMenu();
			}			

			else {
			
			$output	=	"";
			}
		
		return $output;
	}
}