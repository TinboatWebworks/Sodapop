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
	* getPageListData() 
	*/		
	public function getPagesListData() {

		$query	= " select 		*
					from 		pages
					order by	name";			
	
		$result	= $this->getData($query);

		$result	= $this->buildResultArray($result);
		
		return $result;	

	}

	/*
	* getModuleData() 
	*/		
	public function getModuleData() {

		$query	= " select 		*
					from 		modules
					order by	id";			
	
		$result	= $this->getData($query);

		$result	= $this->buildResultArray($result);
		
		return $result;	
	
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

	public Function updatePages($values) {

		$values = extract($values);
		
		$updatePages = implode($pages, ",");

		$query	= "update modules ";
		if ($updatePages == '0') {
			$query	.= "set pages 	= '' ";
		}
		else {
			$query	.= "set pages 	= '" . $updatePages ."' ";
		}
					
		$query	.= "where id	= '". $id . "'";
					
		return	$result	= $this->getData($query);			
	}

	public Function updateHidden($values) {

		$values = extract($values);
		
		$updateHidden = implode($hidden, ",");

		$query	= "update modules ";
		if ($updateHidden == '0') {
			$query	.= "set hidden 	= '' ";
		}
		else {
			$query	.= "set hidden 	= '" . $updateHidden ."' ";
		}
					
		$query	.= "where id	= '". $id . "'";
					
		return	$result	= $this->getData($query);			
	}	
}