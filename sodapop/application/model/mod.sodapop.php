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

		$result = mysql_query($query) or die("Couldn't execute query");
			
		return $result;
	}
	
	/*
	*  getDefaultTemplate loads the template that is set as default in the 
	*  tamplates table.    
	*/			
	public function templateLookup() {

		## Let's find out which template is set to default
		$query	= " select 	*
					from 	templates
					where 	dflt = '1'";
												
		$result	= $this->getData($query);
		
				while ($row= mysql_fetch_array($result, MYSQL_ASSOC)) { 
				
					$template['name']	= $row['name'];
					$template['id']		= $row['templateID'];					
		}
		
		return $template;
	}

	/*
	*  appData retrieves all the info from the apps table for the given handle and packs it into the $app array.  If no app existis, it routes to a 404 app...  
	*/		
	public function pageData($sodapop) {
	
		// Get the handle
		$this->handle	= $sodapop->getHandle();

			
		// Get the app data from the table for this handle
		$query	= " select 	*
					from 	pages
					where 	handle = '$this->handle'";
												
		$result	= $this->getData($query);
		
				while ($row= mysql_fetch_array($result, MYSQL_ASSOC)) { 
					
					$page['id']			= $row['pageID'];
					$page['name']		= $row['name'];
					$page['handle']		= $row['handle'];	
					$page['getApp']		= $row['getApp'];						
					}

		// So what happens if there is not a app for the handle?  We'll load the 404 app, that's what happens.
		if (!$page['id']) {
		
					$page['getApp']	= "404";	
		}

		return $page;
	}

	
	/*
	*  	modsInPosition($position) determines which modules are to be loaded for the given position,
	*	then processes all the info from the modules in that position loading them into
	*	an array $mod then returning the array  
	*/	
	public function modsInPosition($position) {
	
		$query	= " select 	*
			from 	modules
			where 	positions = '$position'
			order by ordering";
	
		$result	= $this->getData($query);
		
			while ($row= mysql_fetch_array($result, MYSQL_ASSOC)) {

				$i++;
				
				$mod[$i]['id']				= $row['id'];
				$mod[$i]['name']			= $row['name'];
				$mod[$i]['positions']		= $row['positions'];
				$mod[$i]['pages']			= $row['pages'];	
				$mod[$i]['hidden']			= $row['hidden'];
				$mod[$i]['params']			= $row['params'];		
				$mod[$i]['active']			= $row['active'];		
				
			
				//I want to move this logic out of the model, but it's gonna live
				//here for now:
				$params	= explode("::", $mod[$i]['params']);
				
				foreach ($params as $k) {
				
					list ($name, $value)	= explode("==", $k);				
					$mod[$i][$name]			= $value;
									
				}								
			}		
				
		return $mod;			
	}
	
		/*
		*  	getUserDataById($id) acceptes the user's ID number and pulls all of their user
		*	data based on that. 
		*/		
		public function getUserDataById($id) {

		$query	= " select 	*
			from 	app_user_users
			where 	id = '$id'";			
	
		$result	= $this->getData($query);
		
		while ($row= mysql_fetch_array($result, MYSQL_ASSOC)) {

				
				$userData['id']				= $row['id'];
				$userData['name']			= $row['name'];
				$userData['email']			= $row['email'];
				$userData['username']		= $row['username'];
				$userData['bio']			= $row['bio'];	
				$userData['accessLevel']	= $row['accessLevel'];											
			}

		return $userData;		
	}

		/*
		*  	getModuleData($id) pulls module data from the db based on the modules ID number
		*	then returns an array of that data.
		*/	
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
}



