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

class appView extends view {

	public $data;

	public function appView() {
	
	}
		
	public function buildViewApp($data) {

	global $language;	

		$viewApp	= $data['appView'];
				
		return $viewApp;
	}
	
	public function buildRgstnForm($sodapop) {

		//require_once "./apps/user/assets/javascript/regFormValidation.php";
	
		$formFields = array ( 
						name,
						userName,
						email,
						pwd,
						pwdConfirm);
	
		$form	= $this->validator("Register", $formFields);
		
		$form	.= "

			<form name='Register' onsubmit='return validateFormOnSubmitRegister(this)' action='http://localhost/~brad/git/Sodapop/sodapop/user?action=create' method='post'>
					Name: <input type='text' name='name'> <br />
					Username: <input type='text' name='username'> <br />
					Email: <input type='text' name='email'> <br /> 
					Password: <input type='text' name='pwd'> <br />
					Confirm Password: <input type='text' name='pwdConfirm'> <br />
					<input name='redirect' type='hidden' value='http://localhost/~brad/git/Sodapop/sodapop/user'>
					<input name='Submit' type='submit' value='Register'>
			</form>";
	
		return $form;
	
	}
	
	public function buildProfile($sodapop) {
	
		$cookie		= $sodapop->getCookie("sp_login");
		$userInfo	= $sodapop->database->getUserDataById($cookie);	
		
		if (!$cookie) {
		
			$output = "Please log in.";
		}
		
		else {
	
			$output	= "<h1>Profile:</h1> ";
		
			$output .= "<strong>User Name:</strong> " . $userInfo['username'] . "<br />";
			$output .= "<strong>Name:</strong> " . $userInfo['name'] . "<br />";
			$output .= "<strong>email:</strong> " . $userInfo['email'] . "<br />";
			$output .= "<br /><a href='http://localhost/~brad/git/Sodapop/sodapop/user?action=logout'>Log out</a>";
			
			
		
		}
		
		return $output;
	}
	
	public function validator($formName, $fields) {

		$fields	= $this->getFields($fields);

		$validator = '
			<script type="text/javascript">
				function validateFormOnSubmit' . $formName . '(theForm) {
				var reason = "";
				';

		if ($fields['name'] == '1') {	
			$validator .= '	
					reason += validateName(theForm.name);';
		}

		if ($fields['userName'] == '1') {	
			$validator .= '	
					reason += validateUsername(theForm.username);';
		}
		
		if ($fields['pwd'] == '1') {	
			$validator .= '	  	
					reason += validatePassword(theForm.pwd);';
		}
		
		if ($fields['pwdConfirm'] == '1') {	
			$validator .= '	 
					reason += validatePasswordConfirm(theForm.pwdConfirm, theForm.pwd);';
		}	  	 
		if ($fields['email'] == '1') {	
			$validator .= '				
					reason += validateEmail(theForm.email);';
		}
		if ($fields['phone'] == '1') {	
			$validator .= '				  
					reason += validatePhone(theForm.phone);';
		}	  	  

	  	$validator .= '
	  	
				if (reason != "") {
					alert("Some fields need correction:\n\n" + reason);
					return false;
				}

				  return true;
				}

				function validateEmpty(fld) {
					var error = "";
  
					if (fld.value.length == 0) {
						fld.style.background = \'Yellow\'; 
						error = "The required field has not been filled in.\n"
					} else {
						fld.style.background = \'White\';
					}
					return error;   
				}

				function validateName(fld) {
					var error = "";
					var illegalChars = /\W/; // allow letters, numbers, and underscores
 
					if (fld.value == "") {
						fld.style.background = "Yellow"; 
						error = "You didn\'t enter you name.\n";
					} else if (illegalChars.test(fld.value)) {
						fld.style.background = "Yellow"; 
						error = "The username contains illegal characters.\n";
					} else {
						fld.style.background = "White";
					} 
					return error;
				}

				function validateUsername(fld) {
					var error = "";
					var illegalChars = /\W/; // allow letters, numbers, and underscores
 
					if (fld.value == "") {
						fld.style.background = "Yellow"; 
						error = "You didn\'t enter a username.\n";
					} else if ((fld.value.length < 5) || (fld.value.length > 15)) {
						fld.style.background = "Yellow"; 
						error = "The username is the wrong length.\n";
					} else if (illegalChars.test(fld.value)) {
						fld.style.background = "Yellow"; 
						error = "The username contains illegal characters.\n";
					} else {
						fld.style.background = "White";
					} 
					return error;
				}


				function validatePassword(fld) {
					var error = "";
					var illegalChars = /[\W_]/; // allow only letters and numbers 
 
					if (fld.value == "") {
						fld.style.background = \'Yellow\';
						error = "You didn\'t enter a password.\n";
					} else if ((fld.value.length < 7) || (fld.value.length > 15)) {
						error = "The password is the wrong length. \n";
						fld.style.background = \'Yellow\';
					} else if (illegalChars.test(fld.value)) {
						error = "The password contains illegal characters.\n";
						fld.style.background = \'Yellow\';
					} else if (!((fld.value.search(/(a-z)+/)) && (fld.value.search(/(0-9)+/)))) {
						error = "The password must contain at least one numeral.\n";
						fld.style.background = \'Yellow\';
					} else {
						fld.style.background = \'White\';
					}
				   return error;
				}  
		
						function validatePasswordConfirm(fld, chk) {
					var error = "";
					var illegalChars = /[\W_]/; // allow only letters and numbers 
 
					if (fld.value == "") {
						fld.style.background = "Yellow";
						error = "You didn\'t enter a confirmation password.\n";
					} else if (fld.value != chk.value) {
						error = "The passwords do not match. \n";
						fld.style.background = "Yellow";
					} else {
						fld.style.background = "White";
					}
				   return error;
				} 

				function trim(s)
				{
				  return s.replace(/^\s+|\s+$/, \'\');
				} 

				function validateEmail(fld) {
					var error="";
					var tfld = trim(fld.value);                        // value of field with whitespace trimmed off
					var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/ ;
					var illegalChars= /[\(\)\<\>\,\;\:\\\"\[\]]/ ;
	
					if (fld.value == "") {
						fld.style.background = \'Yellow\';
						error = "You didn\'t enter an email address.\n";
					} else if (!emailFilter.test(tfld)) {              //test email for illegal characters
						fld.style.background = \'Yellow\';
						error = "Please enter a valid email address.\n";
					} else if (fld.value.match(illegalChars)) {
						fld.style.background = \'Yellow\';
						error = "The email address contains illegal characters.\n";
					} else {
						fld.style.background = \'White\';
					}
					return error;
				}
		
				function validatePhone(fld) {
					var error = "";
					var stripped = fld.value.replace(/[\(\)\.\-\ ]/g, \'\'); 

				   if (fld.value == "") {
						error = "You didn\'t enter a phone number. \n ";
						fld.style.background = "Yellow";
					} else if (isNaN(parseInt(stripped))) {
						error = "The phone number contains illegal characters. \n ";
						fld.style.background = "Yellow";
					} else if (!(stripped.length == 10)) {
						error = "The phone number is the wrong length. Make sure you included an area code.\n";
						fld.style.background = "Yellow";
					} 
					return error;
				}

	
				</script>

				';

		
		return $validator;	
	}
	
	public function getFields($checkFields) {
	
	
		foreach ($checkFields as $i) {
			$fields[$i]	= '1';
		}
	
		return $fields;
	
	
	}
	
	
}
