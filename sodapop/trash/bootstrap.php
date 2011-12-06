<?php

require_once "./utilities/configuration.php";

$bootstrap 		= new bootstrap();

$loadLibraries	= $bootstrap->loadApplication();

$application 	= new application();

class bootstrap {

	function loadApplication() {
	
		require_once "./application/classes/class.application.php";
	
	}
}