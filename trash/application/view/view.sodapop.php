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

class view {

	public $templatePath;
	public $loadTemplate;
	public $templateName;
	
	public	$template;	
	
	/*
	*   
	*/		
	public function view() {
	
	
	}

	public function displaySodapop($sodapop) {

	 	require_once $sodapop->template['path'] . "/index.php";
	
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
}

?>