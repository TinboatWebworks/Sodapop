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

class appView extends view {

	public $data;

	public function appView() {
	
	}
		
	public function buildViewApp($data) {

	global $language;	

		$viewApp	= $data['appView'];
		
		return $viewApp;
	}
	
	public function buildRgstnForm() {
	
		$form	= "
			<form name='login' action='http://localhost/~brad/sodapop/user?action=create' method='post'>
					Name: <input type='text' name='name'> <br />
					Email: <input type='text' name='email'> <br /> 
					Password: <input type='text' name='pass'> <br />
					Confirm Password: <input type='text' name='passConfirm'> <br />
					<input type='submit' value='Submit'>
			</form>";
	
		return $form;
	
	}
}
