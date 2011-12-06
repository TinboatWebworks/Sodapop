<?php

/**
* @author 	Brad Grochowski 
* @copyright	2011 Tinboat Webworks
* @version	0.0.1.1
* @link		a url
* @since  	10/20/2011
*/
 
// no direct access
defined('_LOCK') or die('Restricted access');

class application {

	public function application() {
	
	
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
	*  getHandle uses the parsUrl function to get the page handle from the url
	*/
	public function getHandle() {

		$handle		= $this->parseUrl('handle'); 
		return $handle;
	}	

	/*
	*  getQsting uses the parsUrl function to get the page query string from the
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

		## Get the URI for the currently requested page
		$uri	= $_SERVER['REQUEST_URI'];

		## Pull page handle and query string from domain etc 		
		list($domain, $pageUrl)			= explode($config['liveSite'], $uri);

		## Separate the pages handle from the query string
		list($handle, $queryString,)	= explode("?", $pageUrl);
		
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
	*  loadPage builds the path the the requested page, and then loads it up by 
	*  requiring the pages lead file.
	*/	
	public function loadPage() {
	
		global $pageData;
		
		$pagePath	=  "./pages/" . $pageData['getPage'] . "/" . $pageData['getPage'] . ".php";
		require_once $pagePath;
		
	}	

	/*
	*  loadView allows the page's controller to call in the pages view and push
	*  the $data array into it.
	*/	
	public function loadView($data) {
	
		global $pageData;
		
		$pagePath	=  "./pages/" . $pageData['getPage'] . "/view.php";
		
		require_once $pagePath;

		$viewPage	= new viewPage($data);
		
		return $viewPage;
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
		global $pageData;		

		$language	= $this->setLanguage();
		
		// Load Application Language
		if ($scope == "app") {
			$langPath = "./language/lang." . $language . ".php";
		
		}
		
		// Load Template Language
		if ($scope == "template") {
		
			$templatePath 	= view::templatePath($template['name']);
			$langPath		= $templatePath . "/language/lang." . $language . ".php";
		}
		
		// Load Template Language
		if ($scope == "page") {
		
			$getPage 	= $pageData['getPage'];

			// So, here we have to get the getPage from the database...				
			
			$langPath	= "./pages/" . $getPage . "/language/lang." . $language . ".php";
		}		
		
		return $langPath;
	}	


####
## Coming Soon!
####
	
	public function loadModule() {
	
	
	}	

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