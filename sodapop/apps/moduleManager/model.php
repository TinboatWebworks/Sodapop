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
echo $accessLevel;				
				switch ($accessLevel) {
				
					case '1':
						$level['one']	= " selected='selected '";
						break;
						
					case '2':
						$level['two']	= " selected='selected '";
						break;	

					case '3':
						$level['three']	= " selected='selected '";
						break;
						
					case '4':
						$level['four']	= " selected='selected '";
						break;
	
					case '5':
						$level['five']	= " selected='selected '";
						break;												
				
					case '6':
						$level['six']	= " selected='selected '";
						break;	

					case '7':
						$level['seven']	= " selected='selected '";
						break;

					case '8':
						$level['eight']	= " selected='selected '";
						break;
						
					case '9':
						$level['nine']	= " selected='selected '";
						break;

					case '10':
						$level['ten']	= " selected='selected '";
						break;		
				}
										
	
	
				
				$moduleList	.="<tr>";
				$moduleList	.="<td>" .$id . "</td>";
				$moduleList	.="<td>" . $name . "</td>";
				$moduleList	.="<td>" . $positions . "</td>";
				$moduleList	.="<td>" . $ordering . "</td>";
				$moduleList	.="<td>" . $pages . "</td>";
				$moduleList	.="<td>" . $hidden . "</td>";
				$moduleList	.="<td>" . $params . "</td>";
				$moduleList	.="<td><a href='?action=updateStatus&current=" . $active . "&id=" . $id . "'>" . $activeStatus . "</a></td>";
				$moduleList	.="<td><form action='?action=updateAccess' method='GET'>";
				$moduleList	.="<input type='hidden' name='action' value='updateAccess'>";
				$moduleList	.="<input type='hidden' name='id' value='". $id ."'>";
				$moduleList	.="<select onchange='this.form.submit()' name='access'>";
				$moduleList	.="			<option" . $level['one'] . ">1</option>
										<option" . $level['two'] . ">2</option>
										<option" . $level['three'] . ">3</option>
										<option" . $level['four'] . ">4</option>
										<option" . $level['five'] . ">5</option>
										<option" . $level['six'] . ">6</option>
										<option" . $level['seven'] . ">7</option>
										<option" . $level['eight'] . ">8</option>
										<option" . $level['nine'] . ">9</option>
										<option" . $level['ten'] . ">10</option>";
				$moduleList	.="</select></form></td>";
				$moduleList	.="</tr>";
				
				$level = "";														
			}

		return $moduleList;	
	
	}

	public Function switchStatus($module) {
	
		$status	= $module['current'];
		$id		= $module['id'];
	
		$query	= "update modules set ";
						
		if($status == '1') { 	$query	.= "active = '0'"; }
		if($status == '0') {	$query	.= "active = '1'"; }				
		
		$query	.= " where	id			= '$id'";		
		
		$result	= $this->getData($query);	
	
	}

	public Function updateAccessLevel($module) {

		$level	= $module['access'];
		$id		= $module['id'];
	
		$query	= "update modules set ";
		$query	.= "accessLevel = '$level' "; 			
		$query	.= "where id	= '$id'";		

		return	$result	= $this->getData($query);	
	}

}