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
		
		require_once $this->sodapop->pageData['filePath'] . "/model.php";
		$this->appModel	= new appModel;
	
	}


	/*
	* buildModelList() 
	*/		
	public function buildModuleList($modulesData) {
	
		foreach($modulesData as $moduleData) {
				
				$moduleData		=	extract($moduleData);

				if($active=='1') {$activeStatus	= "Y";}
				else {$activeStatus	= "N";}
													
				$selectsForAccess	= $this->selectSelector($accessLevel);	
					
				$moduleList	.="<tr>";
				$moduleList	.="<td>" .$id . "</td>";
				$moduleList	.="<td>" . $name . "</td>";
				$moduleList	.="<td>" . $positions . "</td>";
				$moduleList	.="<td>" . $ordering . "</td>";
				$moduleList	.="<td><form action='?action=updatePages&current=" . $active . "&id=" . $id . "'' method='GET'>";
				$moduleList	.="<input type='hidden' name='action' value='updatePages'>";
				$moduleList	.="<input type='hidden' name='id' value='". $id ."'>";
				$moduleList	.="<select name='pages' multiple>";
				$moduleList	.="<option>All</option>";
				$moduleList	.= $this->buildPageList(); 
				$moduleList	.="</select><input type='submit' value='update'></form></td>";
				$moduleList	.="<td>" . $hidden . "</td>";
				$moduleList	.="<td>" . $params . "</td>";
				$moduleList	.="<td><a href='?action=updateStatus&current=" . $active . "&id=" . $id . "'>" . $activeStatus . "</a></td>";
				$moduleList	.="<td><form action='?action=updateAccess' method='GET'>";
				$moduleList	.="<input type='hidden' name='action' value='updateAccess'>";
				$moduleList	.="<input type='hidden' name='id' value='". $id ."'>";
				$moduleList	.="<select onchange='this.form.submit()' name='access'>";
				$moduleList	.="			<option" . $selectsForAccess['1'] . ">1</option>
										<option" . $selectsForAccess['2'] . ">2</option>
										<option" . $selectsForAccess['3'] . ">3</option>
										<option" . $selectsForAccess['4'] . ">4</option>
										<option" . $selectsForAccess['5'] . ">5</option>
										<option" . $selectsForAccess['6'] . ">6</option>
										<option" . $selectsForAccess['7'] . ">7</option>
										<option" . $selectsForAccess['8'] . ">8</option>
										<option" . $selectsForAccess['9'] . ">9</option>
										<option" . $selectsForAccess['10'] . ">10</option>";
				$moduleList	.="</select></form></td>";
				$moduleList	.="</tr>";
				
				$level = "";														
			}

		return $moduleList;	
	}
	
	public function selectSelector($accessLevel) {
		
		$output[$accessLevel]	=  " selected='selected' ";
		
		return $output;
	}


	/*
	* buildPageList() 
	*/		
	public function buildPageList() {

		$pagesListData	=	$this->appModel->getPagesListData();
		
		foreach($pagesListData as $pageListData) {

			$pageListData	=	extract($pageListData);
			
			$output		.= "<option>" . $name . "</option>";				
		}
	
		return $output;	

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
