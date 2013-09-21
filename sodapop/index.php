<?php


/**
* @author 	Brad Grochowski 
* @copyright	2011 Tinboat Webworks
* @version	0.0.1.3
* @link		a url
* @since  	9/20/2013
*/
 
/*
*	The first thing we want to do is set a lock constant.  Every file will check
* 	against this constant to make it is being loaded by the Sodapop application and 
* 	not by some other means.
*/
define('_LOCK', 1 );

/*
* 	Now to get things started we are going to require the application class and then
* 	instantiate the controller objext
*/
require_once "./application/controller/class.sodapop.php";
$sodapop		= new Sodapop();

/*
*	Now we run loadSodapop to do all of of the bootstrap stuff like grabing the config
*	file and firing up the database, grabing the language files, etc.
*/
$loadSodapop	= $sodapop->loadSodapop();

/*
*	$sodapop->$output hits loadApp to load the current pages app. 
* 	It contains all the output data for the current app as calculated by the 
*	loadApp method on the sodapop controller object.  The app's output can then be
*	passed along to the template.
*/
$sodapop->output 	= $sodapop->loadApp();

/*
*	Finally we push all of the $sodapop data - including the output - to the template 
*	via the view object to display the application in the browser.
*/
$displaySodapop	= $sodapop->view->displaySodapop($sodapop);

/*
* And that's it!  That's all we needed to do.  Thanks for using Sodapop!
*/