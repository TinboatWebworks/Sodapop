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

/*
*	Let's star here by loading the configuration file.  This will set the basic 
*	needed parameters of the application, and grab the database credentas.
*/
	require_once "./utilities/configuration.php";

/*
*	Now we need to step into the controller file, and create the controller object.
*	In to controller we define all the necissary global methods that will be available
*	throughout the application.
*/
	require_once "./application/controller/class.sodapop.php";
	$sodapop 	= new sodapop();

/*
*	And now we step into the model file where we will declare all of the database-facing
*	methods, then declare the $database object.
*/
	require_once "./application/model/mod.sodapop.php";
	$database		= new database(); 	// This is the appliction model

/*
*	And then of course we want to load the view class and it's methods and create the
*	view object.
*/
	require_once "./application/view/view.sodapop.php";
	$view				= new view(); 		// Loads the view class
	
/* 
*	Now we are going to initiate the database connectsion, using the credentials that
*	we got from the configuration file.
*/
	$dbConnect		= $sodapop->dbConnect();

/*
*	We need to know what language we are currently using.  This has to be fleshed out
*	later.  For now, Im just hard-setting the language to English in the following
*	method.  But I want to be able to switch the language based on a paramter setting or
* 	cookie.  So, I've left the door open for a much better solution, but for now...
* 	you get English and that's it.
*/
	$currentLanguage = $sodapop->setLanguage();

/*
*	And now we check the db to see which template we are supposed to load
*/	
	$template		= $database->templateLookup	();

/*
* 	And then generate the path to the template we are going to load.
*/
	$template['path']	= $view->loadTemplate($template['name']);

/*
* 	Now we need to figure out what app to load based on what page we are on.  The application
* 	uses the second piece of the uri as a 'handle' and uses that to determine which app should
* 	be loaded.  Here we are doing the business of paring the uri to get the handle and
*	doing a db lookup so that we know which app to load.
*/
	$pageData			=  $database->pageData();
	
/*
*	We grab they system language files.  Note that there is system language, as well as
* 	language files specifically for the app being loaded, as well as the current template.
*/

	$langPathApp		= $sodapop->langPath("sodapop");  
	$langPathTem		= $sodapop->langPath("template");
	$langPathApp		= $sodapop->langPath("app");

	require_once		$langPathApp; 		// Load Applicaiton language file	
	require_once		$langPathTem; 		// Load Template Language file
	require_once		$langPathApp; 		// Load app Language file
	

	
	
	
	










