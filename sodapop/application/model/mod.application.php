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
	*  pageData retrieves all the info from the pages table for the given handle and packs it into the $page array.  If no page existis, it routes to a 404 page...  
	*/		
	public function pageData() {
	
		global $application;
	
		## Get the handle
		$handle	= $application->getHandle();
			
		## Get the page data from the table for this handle
		$query	= " select 	*
					from 	pages
					where 	handle = '$handle'";
												
		$result	= $this->getData($query);
		
				while ($row= mysql_fetch_array($result, MYSQL_ASSOC)) { 
					
					$page['id']			= $row['pageID'];
					$page['handle']		= $row['handle'];	
					$page['getPage']	= $row['getPage'];						
					}

		## So what happens if there is not a page for the handle?  We'll load the 404 page, that's what happens.
		if (!$page['id']) {
		
					$page['getPage']	= "404";	
		}

		return $page;
	}

	
	public function modsInPosition ($position) {
		
		$query	= " select 	*
			from 	modules
			where 	positions = '$position'";
		
		$result	= $this->getData($query);
		
			while ($row= mysql_fetch_array($result, MYSQL_ASSOC)) {

				$mod['id']				= $row['id'];
				$mod['name']			= $row['name'];
				$mod['positions']		= $row['positions'];
				$mod['pages']			= $row['pages'];	
				$mod['hidden']			= $row['hidden'];
				$mod['params']			= $row['name'];											
			}

		return $mod;
		
		
	}
}



