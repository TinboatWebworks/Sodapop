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

class sodapop {

	public function sodapop() {
	
	
	}


	/*
	*  dbConnect takes care of the db connection
	*/
	function dbConnect() {

		global $config;
		
		$link 	= mysql_connect(
								$config['dbServer'], 
								$config['dbUser'], 
								$config['dbPass']); 
		if (! $link) {
			die("Couldn't connect to MySQL");
		}	
		mysql_select_db($config['dbName'] , $link)
		or die("Couldn't open" . $config['dbName'] . ": ".mysql_error());
	
	}


	/*
	*  getHandle uses the parsUrl function to get the app handle from the url
	*/
	public function getHandle() {

		$handle		= $this->parseUrl('handle'); 	
		return $handle;
		
	}	

	/*
	*  getQsting uses the parsUrl function to get the app query string from the
	*  url
	*/
	public function getQstring() {

		$qString	= $this->parseUrl('qString');
			
		return $qString;						
	}	
		
			
	/*
	*  parseUrl retrieves the URI and breaks it up into it's various parts
	*/
	public function parseUrl($part) {

		global $config;

		## Get the URI for the currently requested app
		$uri	= $_SERVER['REQUEST_URI'];		
		
		## Pull app handle and query string from domain etc 		
		list($domain, $appUrl)			= explode($config['liveSite'], $uri);
		
		## Separate the apps handle from the query string
		list($handle, $queryString,)	= explode("?", $appUrl);

			
		
		## Ditch the slash separator
		$handle	= str_replace("/", "", $handle);

		if ($part == 'handle')	{
		
			$string	= $handle;
		}
		
		if ($part == 'qString') {
		
			$string	= $queryString;
		}
				
		return $string;
	}
	

	/*
	*  loadApp builds the path the the requested app, and then loads it up by 
	*  requiring the apps lead file.
	*/	
	public function loadApp() {
	
		global $appData;
		
		$appPath	=  "./apps/" . $appData['getApp'] . "/" . $appData['getApp'] . ".php";
		
		require_once $appPath;
		
	}	

	/*
	*  loadView allows the app's controller to call in the apps view and push
	*  the $data array into it.
	*/	
	public function loadView($data) {
	
		global $appData;
		
		$appPath	=  "./apps/" . $appData['getApp'] . "/view.php";
		
		require_once $appPath;

		$viewApp	= new viewApp($data);
		
		return $viewApp;
	}
	
	
	/*
	*  setLanguage determines which language file to pull from... defaulting to 
	*  english. 
	*/		
	public function setLanguage() {

		/* Once cookies are working:
		$language	= getCookie("language");
		*/
		
		// but for now:
		$language = "english";
		
		if (!$language) {
			$language	= "english";
		}		

		return $language;	
	}


	/*
	*  langPath sets the path to the language files  
	*/		
	public function langPath($scope) {
	
		global $template;
		global $appData;		

		$language	= $this->setLanguage();
		
		// Load Application Language
		if ($scope == "sodapop") {
			$langPath = "./language/lang." . $language . ".php";
		
		}
		
		// Load Template Language
		if ($scope == "template") {
		
			$templatePath 	= view::templatePath($template['name']);
			$langPath		= $templatePath . "/language/lang." . $language . ".php";
		}
		
		// Load Template Language
		if ($scope == "app") {
		
			$getApp 	= $appData['getApp'];

			// So, here we have to get the getApp from the database...				
			
			$langPath	= "./apps/" . $getApp . "/language/lang." . $language . ".php";
		}		
		
		return $langPath;
	}	


	/*
	*  modPosition determines which modules are assigned to the given module position
	*/	
	
	public function modPosition($position) {
	
		global $database;
		
		// This grabs the data from the db table for the modules assigned to the 
		// given position, including the module's name
		$allModsData = $database->modsInPosition ($position);
		
		$this->loadModule($allModsData);
	
	}	 
	
	
	/*
	 *  loadModule loads all the modules for the given position
	 */
	public function loadModule($allModsData) {
			
		
		// How many modules are in this position so we know how many times to loop
		$moduleCount	= count($allModsData);
		
		// Scroll thru the modules by $i, picking out the data from each modules sub-array
		for ($i = 1; $i<= $moduleCount; $i++) {				

			// Create an array of this module's data from the subaray of all the modules' data
			$modData	= $allModsData[$i];
				
			// Find out if we are supposed to show this module or not
			$showIt	= $this->doShowModule($modData);

			// And show it if we are
			if ($showIt == true) {
									
				// get the path to the requested module then pulls it in
				$modulePath	=  $this->buildModPath($modData['name']);
				
				// Fetches the modules index file if it exists
				if (file_exists($modulePath)) {

					require $modulePath;

				} 
			}	
		}
	}	

	
	/*
	 *  buildModPath creates the path to the module's index app
	*/
	
	public function buildModPath($modDataName) {
		
		$modulePath	=  "./modules/mod_" . $modDataName . "/" . $modDataName . ".php";
		return $modulePath;
		
	}
	
	
	/*
	 *  We need to find out whether or not to show the module on this app.
	*  This is ugly and probably needs to be refactored
	*/
	
	public function doShowModule($modData) {
		
		global $appData;
		
		// Is the current app one that the module is supposed to show up on?
		// we compare the current app's name to the 'apps' field in the module
		// to see if it's in there
		$isItThisApp	= strpos("_" . $modData['apps'], $appData['getApp']);
		
		// Is the current app one that the module us supposed to be hidden from?
		// we compare the current app's name to the 'hidden' field in the module
		// to see if it's in there
		$hideOnThisApp	= strpos("_" . $modData['hidden'], $appData['getApp']);
			
		// if the module is assigned to all apps ('apps' field is blank) and the module 
		// is not hidden from this app, then we can show the module.
		if 	(($modData['apps'] == '') && ($hideOnThisApp === false)) {

			$showIt = true;	
					
		}

		// If it the module is assigned to this app, then we can show the module
		else if ($isItThisApp == true ) {

			$showIt = true;
					
		} 
		
		// unless it's explicitly hidden from this app, then we won't show it.
		if ($hideOnThisApp == true) {

			$showIt	= false;
			
		}
				
		return $showIt;	
				
	}
	
	####
	## Coming Soon!
	####	
	
	public function request($InputString) {
	
	
	}	
	
	
	public function setCookie($userID, $cookieName, $value, $duration) {
	
	
	}
	
	public function getCookie($cookieName) {
	
	
	}	
	
	public function deleteCookie($cookieName) {
	
	
	}
	
	
	public function getChart($chartType, $chartData) {
	
	
	}

	
	public function registerEvent($eventType, $userID, $EpisodeID, $ShowID) {
	
	
	}

	
	public function hashIt($string) {
	
		$string	= md5($string);
		$string	= md5($string);
		
		return $string;
	
	}
}


?>