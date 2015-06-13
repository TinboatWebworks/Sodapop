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

class appView extends view {

	public $data;
	
	public function appView() {
	
	 	global $sodapop; // Let's bring in the global app object so we can access all the environmental info...
		$this->sodapop	= $sodapop; // And give it to this class
	
	}
	
	public function listModules($moduleList) {
	
		$id = $this->sodapop->getCookie("sp_login");
	
		if ($this->sodapop->checkAccessLevel($id) < 5) {
		
			$output = "No Dice";
		}
		
		else {
		
			$output	= "Module Manager";			
			
			// And build the list of users.	
			$output	.= "<table width='100%'>
						<tr>
							<td><strong>ID</strong></td>
							<td><strong>Name</strong></td>
							<td><strong>Position</strong></td>
							<td><strong>Order</strong></td>
							<td><strong>Pages</strong></td>
							<td><strong>Hidden</strong></td>
							<td><strong>Params</strong></td>
							<td><strong>Active</strong></td>
							<td><strong>Access</strong></td>
						</tr>"
							 . $moduleList . "	 
						</table>";

		}
		
		return $output;
	
	}
	
}
