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

class database {

	private $result;
	private $query;
	private $template;
	private $row;
	private $handle;
	private $page;
	private $i;
	private $mod;
	public $sodapop;

	
	public function database() {
		
		global $sodapop;
		$this->sodapop;

	}
	/*
	*  loadConfigFile() grabs the config file and generates the config array $sodapop->config
	*/		
	public function loadConfigFile() {
	
		require "./utilities/configuration.php";
		return $config;
	}

	/*
	*  getData performs the basic db query, and add scrubbing for sql injection 
	*  protection. 
	*/		
	public function getData($query) {

		#####
		## Add some sql injection protection here? Scrub the $query before 
		## sending it to the db
		#####
		
		$config	= $this->loadConfigFile();

		$this->config	= $config;

		$con	= mysqli_connect(
		$config['dbServer'], 
		$config['dbUser'], 
		$config['dbPass'],
		$config['dbName']);
		
//		echo $config['dbServer'].",".$config['dbUser'].",".$config['dbPass'].",".$config['dbName'];

		$result = mysqli_query($con, $query) or die("Couldn't execute this query");
			
		return $result;
	}	
	
	/*
	*  getDefaultTemplate loads the template that is set as default in the 
	*  tamplates table.    
	*/			
	public function getTemplatesData() {

		## Let's find out which template is set to default
		$query	= " select 	*
					from 	templates
					where 	dflt = '1'";
												
		$result	= $this->getData($query);
		
		$result	= $this->buildResultArray($result);
		
		return $result;
	}

	/*
	*  appData retrieves all the info from the apps table for the given handle and packs it into the $app array.  If no app existis, it routes to a 404 app...  
	*/		
	public function getPagesData($handle) {
	
			
		// Get the app data from the table for this handle
		$query	= " select 	*
					from 	pages
					where 	handle = '$handle'";
												
		$result	= $this->getData($query);
		
		$result	= $this->buildResultArray($result);
		
		return $result;
	}

	
	/*
	*  	modsInPosition($position) determines which modules are to be loaded for the given position,
	*	then processes all the info from the modules in that position loading them into
	*	an array $mod then returning the array  
	*/	
	public function modsInPostionData($position) {
	
		$query	= " select 	*
			from 	modules
			where 	positions = '$position'
			order by ordering";
	
		$result	= $this->getData($query);
		
		$result	= $this->buildResultArray($result);								
				
		return $result;			
	}
	
	
	/*
	*  	modsInPosition($position) determines which modules are to be loaded for the given position,
	*	then processes all the info from the modules in that position loading them into
	*	an array $mod then returning the array  
	*/	
	public function modsOnPageData($page) {
	
		$query	= " select 	*
			from 	modules
			where 	page = '$position'
			order by ordering";
	
		$result	= $this->getData($query);
		
		$result	= $this->buildResultArray($result);								
				
		return $result;			
	}
	
	/*
	*  	getUserDataById($id) acceptes the user's ID number and pulls all of their user
	*	data based on that. 
	*/		
	public function getUsersByIdData($id) {

		$query	= " select 	*
			from 	app_user_users
			where 	id = '$id'";			
	
		$result	= $this->getData($query);
		
		$result	= $this->buildResultArray($result);	
		
		return $result;		
	}
	
	/*
	*  	getUserDataById($id) acceptes the user's ID number and pulls all of their user
	*	data based on that. 
	*/		
	public function checkAccessLevelData($id) {
	
		$query	= " select 	accessLevel
			from 	app_user_users
			where 	id = '$id'";
		
		$result	= $this->getData($query);
		
		$result	= $this->buildResultArray($result);	
		
		return $result;	
	}
	

	/*
	*  	getModuleData($id) pulls module data from the db based on the modules ID number
	*	then returns an array of that data.
	*	
	public function getModuleData($id) {

		$query	= " select 	*
			from 	modules
			where 	id = '$id'";			
	
		$result	= $this->getData($query);
		
		while ($row= mysql_fetch_array($result, MYSQL_ASSOC)) {

				
				$moduleData['id']				= $row['id'];
				$moduleData['name']				= $row['name'];
				$moduleData['positions']		= $row['positions'];
				$moduleData['pages']			= $row['pages'];	
				$moduleData['hidden']			= $row['hidden'];		
				$moduleData['params']			= $row['params'];
				$moduleData['ordering']			= $row['ordering'];		
				$moduleData['active']			= $row['active'];										
			}

		return $moduleData;	
	}
	*/
	
	public Function buildResultArray($result) {
	
		while ($row= mysqli_fetch_array($result, MYSQL_ASSOC)) {
			
		    if(empty($i)) {$i="";}
			$i++;
			$thisResult[$i]		= $row;	
		}
		
		if (empty($thisResult)) {$thisResult = "";}
		
		return $thisResult;	
	}	
}



