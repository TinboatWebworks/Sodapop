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

class database {

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
	public function getDefaultTemplate() {

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
	public function appData() {
	
		global $sodapop;
	
		## Get the handle
		$handle	= $sodapop->getHandle();
			
		## Get the app data from the table for this handle
		$query	= " select 	*
					from 	apps
					where 	handle = '$handle'";
												
		$result	= $this->getData($query);
		
				while ($row= mysql_fetch_array($result, MYSQL_ASSOC)) { 
					
					$app['id']			= $row['appID'];
					$app['handle']		= $row['handle'];	
					$app['getApp']		= $row['getApp'];						
					}

		## So what happens if there is not a app for the handle?  We'll load the 404 app, that's what happens.
		if (!$app['id']) {
		
					$app['getApp']	= "404";	
		}

		return $app;
	}

	
	public function modsInPosition ($position) {
		
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
				$mod[$i]['apps']			= $row['apps'];	
				$mod[$i]['hidden']			= $row['hidden'];
				$mod[$i]['params']			= $row['name'];			
												
			}

		return $mod;
				
	}
}



