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

class sodapop {
	
	public $config;
	public $link;
	public $handle;
	public $qString;
	public $uri;
	public $domain; 
	public $appUrl;
	public $queryString;
	public $part;
	public $string;
	public $appPath;
	public $viewApp;
	public $data;
	public $language;
	public $scope;
	public $langPath;
	public $templatePath;
	public $getApp;
	public $position;
	public $allModsData;
	public $i;
	public $modulePath;
	public $modDataName;
	public $isItThisPage;
	public $hideOnThisPage;
	public $showIt;
	
	public 	$pageData;
	public 	$template;
	public	$modData;

	/*
	*  	sodapop() creates the model and view objects.
	*/  		
	public function sodapop() {
	
		require_once "./application/model/mod.sodapop.php";
		$this->database	= new database;
	
		require_once "./application/view/view.sodapop.php";
		$this->view	= new view;
	}
	
	/*
	*  	loadSodapop() is where we really get everything rolling.  We load the language,
	*	Config file, template, all that good stuff as well as find out what should be
	*	happening on the requested page.
	*/        	
	public function loadSodapop() {
	
		$this->config				= $this->database->loadConfigFile();
//		$this->dbConnect			= $this->dbConnect($this->config);
		$this->currentLanguage 		= $this->setLanguage();
		$this->template				= $this->templateLookup();
		$this->template['path']		= $this->loadTemplate($this->template['name']);
		$this->pageData				= $this->pageData($this);
		$this->pageData['filePath']	= $this->appFilePath();
		$this->loadLanguage			= $this->loadLanguage();		
	}
	
	/*
	*	dbConnect() takes care of the db connection.  Somebody's got to do it.
	*/
	function dbConnect($config) {
		
/*		$link 	= mysqli_connect(
			$config['dbServer'], 
			$config['dbUser'], 
			$config['dbPass'],
			$config['dbName']);
	
			
		if (! $link) {
			die("Couldn't connect to MySQL");
		}	 
		or die("Couldn't open" . $config['dbName'] . ": ".mysql_error());
		*/
	}

	/*
	*  setLanguage() determines which language file to pull from... defaulting to 
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
	*	loadLanguage() loads the language files for the application, apps and modules.
	* 	Language in the apps and template will override core language
	*/
	public function loadLanguage() {
	
		$this->langPath		= $this->langPath("sodapop");  
		$this->langPathTem	= $this->langPath("template");
		$this->langPathApp	= $this->langPath("app");

		require_once 	$this->langPath; 	// Load Applicaiton language file
		require_once	$this->langPathTem; // Load Template Language file
		require_once	$this->langPathApp; // Load app Language file
	}


	/*
	*  getDefaultTemplate loads the template that is set as default in the 
	*  tamplates table.    
	*/			
	public function templateLookup() {

		## Let's find out which template is set to default
		$templatesData	= $this->database->getTemplatesData();
		
				foreach ($templatesData as $templateData) { 
				
					$template['name']	= $templateData['name'];
					$template['id']		= $templateData['templateID'];					
				}
		
		return $template;
	}



	/*
	*  loadTemplate loads the current template 
	*/		
	public function loadTemplate($templateName) {
	
		$loadTemplate = $this->templatePath($templateName);
		
		return $loadTemplate;
	
	}

	/*
	*  templatePath creates the path to the current template.  If no template is 
	*  assigned, or the template file doesn't exist, its going to load a null 
	*  template 
	*/			
	public function templatePath($templateName) {

		if ($templateName == "")  {
		
			## If there is not template assinged were going to load the null template
			$templatePath = "./templates/null";
		}
		
		elseif (!file_exists("./templates/" . $templateName)) {

			## What if there is no template to match what we are looking for?  Load the null template, that's what.	
			$templatePath = "./templates/null";  		
		}
		
		else {
		
			## And assuming all is well, we can load the assigned template
			$templatePath = "./templates/" . $templateName;
		}					
	
		return $templatePath;
	
	}

	/*
	*  appData retrieves all the info from the apps table for the given handle and packs it into the $app array.  If no app existis, it routes to a 404 app...  
	*/		
	public function pageData($sodapop) {
	
		// Get the handle
		$handle	= $this->getHandle();
			
		$pagesData	=	$this->database->getPagesData($handle);
		///////XXXX//////
		// So what happens if there is not a app for the handle?  We'll load the 404 app, that's what happens.
		if (!$pagesData) {
		
			$page['getApp']	= "404";
			
			return $page;	
		}
		
		foreach ($pagesData as $pageData) { 
					
			$page['id']			= $pageData['pageID'];
			$page['name']		= $pageData['name'];
			$page['handle']		= $pageData['handle'];	
			$page['getApp']		= $pageData['getApp'];						
		}

		return $page;
	}


////////////////////////


	/*
	*  	getUserDataById($id) acceptes the user's ID number and pulls all of their user
	*	data based on that. 
	*/		
	public function getUserDataById($id) {

		$getUsersByIdData = $this->database->getUsersByIdData($id);
		
		foreach ($getUsersByIdData as $getUserByIdData) {

				
				$userData['id']				= $getUserByIdData['id'];
				$userData['name']			= $getUserByIdData['name'];
				$userData['email']			= $getUserByIdData['email'];
				$userData['username']		= $getUserByIdData['username'];
				$userData['bio']			= $getUserByIdData['bio'];	
				$userData['accessLevel']	= $getUserByIdData['accessLevel'];											
			}

		return $userData;		
	}


	/*
	*	getHandle() uses the parsUrl() function to get the app handle from the url
	*/
	public function getHandle() {

		$handle		= $this->parseUrl('handle'); 	
		return $handle;		
	}	

	/*
	*	getQsting() uses the parsUrl() function to get the app query string from the
	*	url
	*/
	public function getQstring() {

		$qString	= $this->parseUrl('qString');
			
		return $qString;						
	}	
		
			
	/*
	*	parseUrl() retrieves the URI and breaks it up into it's various parts
	*/
	public function parseUrl($part) {

		## Get the URI for the currently requested app
		$uri	= $_SERVER['REQUEST_URI'];		
		
		## Pull app handle and query string from domain etc 		
		list($this->domain, $this->appUrl)	= explode($this->config['liveSite'], $uri);

		## Separate the apps handle from the query string
		list($this->handle, $this->queryString,)	= explode("?", $this->appUrl);			
		
		## Ditch the slash separator
		$this->handle	= str_replace("/", "", $this->handle);

		if ($part == 'handle')	{
		
			$this->string	= $this->handle;
		}
		
		if ($part == 'qString') {
		
			$this->string	= $this->queryString;			
			$this->string = $this->getStringVars($this->string);

		}
			
		return $this->string;
	}
	
	/*
	*	getStringVars() takes the parameter strinf in the URL and parses out to it's 
	*	parts.  It creates the variablein an array with the name and value based 
	*	on the string.  So ?something=top&somethingElse=bottom would end as
	*	$urlVals['something']='top'; $urlVals['$something']='bottom'; and then get
	*	returned.
	*/
	public function getStringVars($string){
	
		$string	= explode("&", $string);
	
		foreach ($string as $i) {

			list($name, $value)	= explode("=", $i);			
			$urlVals[$name]	=	$value;
		}
	
		return $urlVals;	
	}
	
	public function newGetStringVariables() {
	
		$values		=	$_GET;
		
		return $values;
					
	}
	

	/*
	*  loadApp() builds the path to the requested app, and then loads it up by 
	*  requiring the apps lead file.
	*/	
	public function loadApp() {
		
		$appPath	=  "./apps/" . 
						$this->pageData['getApp'] . 
						"/" . 
						$this->pageData['getApp'] . 
						".php";
						
		require_once $appPath;
		$output	= $appController->output($this);
		
		return $output;
	}	
	
	public function appFilePath() {

		$appFilePath	=  "./apps/" . $this->pageData['getApp'];
	
		return $appFilePath;
	}

	/*
	*  loadView() allows the app's controller to call in the apps view and push
	*  the $data array into it.
	*/	
	public function loadView() {

		$appPath	=  "./apps/" . $this->pageData['getApp'] . "/view.php";
		
		require_once $appPath;

		$loadViewApp	= new appView($data);
		$appView		= $appView->buildAppView($data);
		
		return $viewApp;
	}
	
	/*
	*  langPath() sets the path to the language files  
	*/		
	public function langPath($scope) {
			
		// Load Application Language
		if ($scope == "sodapop") {
		
			$langPath = "./language/lang." . $this->currentLanguage . ".php";
		}
		
		// Load Template Language
		if ($scope == "template") {
		
			$templatePath 	= $this->templatePath($this->template['name']);
			$langPath		= $templatePath . "/language/lang." . $this->currentLanguage . ".php";
		}
		
		// Load app Language
		if ($scope == "app") {
	
			$getApp 	= $this->pageData['getApp'];

			// So, here we have to get the getApp from the database...				
			
			$langPath	= "./apps/" . $getApp . "/language/lang." . $this->currentLanguage . ".php";
		}		
		
		return $langPath;
	}	


	/*
	*  modPosition() determines which modules are assigned to the given module position
	*/	
	public function modPosition($position) {
		
		// This grabs the data from the db table for the modules assigned to the 
		// given position, including the module's name
		$this->allModsData = $this->modsInPosition($position);			
		
		$moduleData	= $this->loadModule($this->allModsData);
		
		return $moduleData;
	
	}
		 
	
	/*
	*  	modsInPosition($position) determines which modules are to be loaded for the given position,
	*	then processes all the info from the modules in that position loading them into
	*	an array $mod then returning the array  
	*/	
	public function modsInPosition($position) {
	
			$modsInPostionData	= $this->database->modsInPostionData($position);
		
			foreach ($modsInPostionData as $modInPostionData) {

				$i++;
				
				$mod[$i]['id']				= $modInPostionData['id'];
				$mod[$i]['name']			= $modInPostionData['name'];
				$mod[$i]['positions']		= $modInPostionData['positions'];
				$mod[$i]['pages']			= $modInPostionData['pages'];	
				$mod[$i]['hidden']			= $modInPostionData['hidden'];
				$mod[$i]['params']			= $modInPostionData['params'];		
				$mod[$i]['active']			= $modInPostionData['active'];		
				
				$params	= explode("::", $mod[$i]['params']);
				
				foreach ($params as $k) {
				
					list ($name, $value)	= explode("==", $k);				
					$mod[$i][$name]			= $value;
									
				}								
			}		
				
		return $mod;			
	}
	
	/*
	 *  loadModule() loads all the modules for the given position #on the given page
	 */
	private function loadModule() {
					
		// How many modules are in this position so we know how many times to loop
		$moduleCount	= count($this->allModsData);
		
		// Scroll thru the modules by $i, picking out the data from each modules sub-array
		for ($i = 1; $i<= $moduleCount; $i++) {				

			// Create an array of this module's data from the subaray of all the modules' data
			$modData	= $this->allModsData[$i];
				
			// Find out if we are supposed to show this module or not
			$showIt		= $this->doShowModule($modData);

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
	*  buildModPath() creates the path to the module's index app
	*/
	private function buildModPath($modDataName) {
		
		$modulePath	=  "./modules/mod_" . $modDataName . "/" . $modDataName . ".php";

		return $modulePath;		
	}
	
	/*
	*  We need to find out whether or not to show the module on this app.
	*  This is ugly and probably needs to be refactored
	*/
	private function doShowModule($modData) {
		

	
		//  What if there is no handle?  Then we will set the handle to 'home'
		if ($this->pageData['handle'] == "") {$this->pageData['handle'] = 'home';}
	
		// Is the current page one that the module is supposed to show up on?
		// we compare the current page's id to the 'pages' field in the module
		// to see if it's in there
		$isItThisPage	= strpos("," . $modData['pages'], $this->pageData['id']);

		// Is the current page one that the module us supposed to be hidden from?
		// we compare the current pages's id to the 'hidden' field in the module
		// to see if it's in there
		$hideOnThisPage	= strpos("," . $modData['hidden'], $this->pageData['id']);
							
		// if the module is assigned to all apps ('pages' field is blank) and the module 
		// is not hidden from this page, then we can show the module.
		if 	(($modData['pages'] == '') && ($hideOnThisPage === false)) {

			$showIt = true;	
					
		}

		// If it the module is assigned to this page, then we can show the module
		else if ($isItThisPage == true ) {

			$showIt = true;
					
		} 
		
		// unless it's explicitly hidden from this page, then we won't show it.
		if ($hideOnThisPage == true) {

			$showIt	= false;
			
		}
		
		// Is the module set to active?  If not, then lets hide it.
		$isItActive	= $modData['active'];
		
		if ($isItActive == '0') {
		
			$showIt	= false;
			
		}		
			
		return $showIt;		
	}
	
	
	/*
	*  	parseModParams() was intended to parse out the parameter of the module
	*  	but I think that's currently being done in mod.sodapop.pop in getModuleData()
	*	This  method can probably be removed.
	*	
	public function parseModParams($modParams) {
	
		$modParams	= '';
	}
	/*
	
	/*
	*  	getFormData() should be getting the data submitted by a form.  It sends it to 
	*	scrubFormData to clean it up from injection attacks, etc.
	*/	
	public function getFormData($data) {
	
		$data	= $this->scrubFormData($data);
		return $data;
	}
	
	/*
	*  	scrubFormData() This needs to be built yet.  It will scrub input form data to  
	*	make sure that there aren't any injection attacks, etc.
	*/
	public function scrubFormData ($data) {
	
		return $data;
	}
	
	/*
	*  	setaCookie():  At this point it just does the same thing as PHP setcookie,
	*	but now we have the option doing some checking before actually setting a 
	*	cookie.
	*/	
	public function setaCookie($cookieName, $userID, $duration) {
	
		setcookie($cookieName, $userID, time()+$duration); 
	}
	
	/*
	*  	getCookie() just grabs a desired cookies value. 
	*/			
	public function getCookie($cookieName) {
	
		$cookie	= $_COOKIE[$cookieName];
		return $cookie;
	}
	
	public function checkAccessLevel($id) {
	
		$accessLevel	= $this->database->checkAccessLevelData($id);
		
		return $accessLevel;	
	}
	
	
	/*
	*  	for hashing things.  Right now it's just a double md5.  Will probably add another
	*	layer of SHA, any suggestion here would be appreciated. 
	*/			
	public function hashIt($string) {
	
		$string	= md5($string);
		$string	= md5($string);
		
		return $string;
	}
	
	
	/*
	*  	randomizedString will generate a string of random numbers up to 62 chars in length.
	* 	Default is 8 chars.  I found this nice tight little function at:
	*	http://stackoverflow.com/questions/853813/how-to-create-a-random-string-using-php
	*	I did not write it myself.
	*/	
	
	public function randomizedString($name_length = 8) {
	
		$alpha_numeric = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	
		return substr(str_shuffle($alpha_numeric), 0, $name_length);
	}
	
	public function sendEmail($emailData) {
	
		$address	= $emailData['email'];
		$subject	= $emailData['subject'];
		$message	= $emailData['message'];
		$headers	= $emailData['headers'];
		$params		= $emailData['params'];		
		
		$sendEmail	= mail($address,$subject,$message);
	
		return $emailData;		
	}
	
}