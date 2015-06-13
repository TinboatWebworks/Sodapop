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

class appModel extends database {

	public function appModel() {
	
		global $sodapop; // Let's bring in the global app object so we can access all the environmental info...
		$this->sodapop	= $sodapop; // And give it to this class
	
	}

	/*
	* buildModelList() 
	*/		
	public function buildModuleList() {

		$query	= " select 		*
					from 		modules
					order by	id";			
	
		$result	= $this->getData($query);
		
		while ($row= mysql_fetch_array($result, MYSQL_ASSOC)) {
				
				$moduleData		=	extract($row);
				
				if($active=='1') {$activeStatus	= "Y";}
				else {$activeStatus	= "N";}
				
				// print_r ($row);
				
				$moduleList	.="<tr>";
				$moduleList	.="<td>" .$id . "</td>";
				$moduleList	.="<td>" . $name . "</td>";
				$moduleList	.="<td>" . $positions . "</td>";
				$moduleList	.="<td>" . $ordering . "</td>";
				$moduleList	.="<td>" . $pages . "</td>";
				$moduleList	.="<td>" . $hidden . "</td>";
				$moduleList	.="<td>" . $params . "</td>";
				$moduleList	.="<td>" . $activeStatus . "</td>";
				$moduleList	.="<td>" . $accessLevel . "</td>";
				$moduleList	.="</tr>";														
			}

		return $moduleList;	
	
	}

}