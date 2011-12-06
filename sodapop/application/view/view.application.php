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

class view {

	/*
	*   
	*/		
	public function view() {
	
	
	}

	/*
	*  loadTemplate goes loads the current template 
	*/		
	public function loadTemplate($templateName) {
	
		global $template;
	
		$templatePath = $this->templatePath($template['name']);
		
		$loadTemplate	= $templatePath;
		
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