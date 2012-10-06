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

## 	Load application controller 
	require_once "./application/controller/class.application.php";
	$application 	= new application();

## 	Load application models

	require_once "./application/model/mod.application.php";
	require_once "./application/model/mod.users.php";	
	require_once "./application/model/mod.shows.php";		

	$database		= new database(); 	// This is the appliction model
	$user			= new user(); 		// Manages user data 
	$show			= new show();		// Manages show and episode data

## 	Load appplication view

	require_once "./application/view/view.application.php";
	
	$view			= new view(); 		// Loads the view class

##	Open databse
	$dbConnect		= $application->dbConnect();

## 	Set language
	$currentLanguage = $application->setLanguage();

## 	Load the template array
	$template		= $database->getDefaultTemplate();

##	Load Template Path
	$template['path']	= $view->loadTemplate($template['name']);

##	Load page data
	$pageData			=  $database->pageData();
	

## 	Load language files

	$langPathApp		= $application->langPath("app");  
	$langPathTem		= $application->langPath("template");
	$langPathPage		= $application->langPath("page");

	require_once		$langPathApp; 		// Load Applicaiton language file	
	require_once		$langPathTem; 		// Load Template Language file
	require_once		$langPathPage; 		// Load page Language file
	

	
	
	
	










