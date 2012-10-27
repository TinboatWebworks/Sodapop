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

## 	Load configuration
	require_once "./utilities/configuration.php";

## 	Load controllers 
	require_once "./application/controller/class.sodapop.php";
	$sodapop 	= new sodapop();
	
	require_once "./application/controller/class.module.php";
	$module 	= new module(); // Manages global module methods

## 	Load models

	require_once "./application/model/mod.sodapop.php";
	require_once "./application/model/mod.users.php";	
	require_once "./application/model/mod.shows.php";
	require_once "./application/model/mod.module.php";

	$database		= new database(); 	// This is the appliction model
	$user			= new user(); 		// Manages user data 
	$show			= new show();		// Manages show and episode data
	$moduleDatabase	= new moduleDatabase();		// Manages global module data
	
## 	Load  views

	require_once "./application/view/view.sodapop.php";
	require_once "./application/view/view.module.php";
		
	$view				= new view(); 		// Loads the view class
	$moduleView			= new moduleView(); 		// Loads the global module view class
	
##	Open databse
	$dbConnect		= $sodapop->dbConnect();

## 	Set language
	$currentLanguage = $sodapop->setLanguage();

## 	Load the template array
	$template		= $database->getDefaultTemplate();

##	Load Template Path
	$template['path']	= $view->loadTemplate($template['name']);

##	Load app data
	$appData			=  $database->appData();
	

## 	Load language files

	$langPathApp		= $sodapop->langPath("sodapop");  
	$langPathTem		= $sodapop->langPath("template");
	$langPathApp		= $sodapop->langPath("app");

	require_once		$langPathApp; 		// Load Applicaiton language file	
	require_once		$langPathTem; 		// Load Template Language file
	require_once		$langPathApp; 		// Load app Language file
	

	
	
	
	










