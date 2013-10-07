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
	
	 	global $sodapop; // Let's bring in the global app object so we can access all the environmental info...
		$this->sodapop	= $sodapop; // And give it to this class
	
	}
		
	public function buildViewApp($data) {

	global $language;	

		$viewApp	= $data['appView'];
				
		return $viewApp;
	}

	/*
	*  	buildRgstnForm() builds the registration form for new registrations
	*/	
	public function buildRgstnForm() {

		//require_once "./apps/user/assets/javascript/regFormValidation.php";

		$formFields = array ( 
						name,
						userName,
						email,
						pwd,
						pwdConfirm);
	
		$form	= $this->validator("Register", $formFields);
		
		$form	.= "

			<div class='registrationForm'>
				<form name='Register' onsubmit='return validateFormOnSubmitRegister(this)' action='" . $this->sodapop->config['liveUrl'] . "user?action=create' method='post'>
					<table class='registrationTable'>
						<tr>
							<td><label for='name'> " . $this->sodapop->language['regName'] . " </label></td>	
							<td><input type='text' name='name'></td>
						</tr>
						<tr>	
							<td><label for='username'> " . $this->sodapop->language['regUsrname'] . "  </label></td>
							<td> <input type='text' name='username'> </td>
						</tr>
						<tr>							
							<td><label for='email'> " . $this->sodapop->language['regEmail'] . " </label></td>
							<td> <input type='text' name='email'> </td>
						</tr>
						<tr>
							<td><label for='pwd'> " . $this->sodapop->language['regPwd'] . "</label> </td>
							<td> <input type='text' name='pwd'> </td>
						</tr>
						<tr>							
							<td><label for='pwdConfirm'> " . $this->sodapop->language['regCnfPwd'] . " </label></td>
							<td> <input type='text' name='pwdConfirm'> </td>
						</tr>
						<tr>							 
							<td> <input name='redirect' type='hidden' value='" . $this->sodapop->config['liveUrl'] . "user'>
								<input name='Submit' type='submit' value='" . $this->sodapop->language['regSubmit'] . "'> </td>
						</tr>
					</table>	
								
				</form>
			</div>";
	
		return $form;
	
	}


	/*
	*  	buildProfile() builds the profile page.  It's super simple here, but could be expanded 
	*	by greated an html.profile.php file and requiring it, or something like that, to 
	*	make it more fancy for your own purposes.
	*/			
	public function buildProfile() {
	
		$cookie		= $this->sodapop->getCookie("sp_login");
		$userInfo	= $this->sodapop->database->getUserDataById($cookie);	
		
		if (!$cookie) {
		
			$output = "Please log in.";
		}
		
		else {
	
			$output	= "<h1>" . $this->sodapop->language['profileTitle'] . "</h1> ";
			$output	.= "<div class='profileData'><table>";
			$output .= "<tr><td><strong>" . $this->sodapop->language['profileName'] . "</strong> </td><td>" . $userInfo['name'] . "</td></tr>";
			$output .= "<tr><td><strong>" . $this->sodapop->language['profileUsrName'] . "</strong> </td><td>" . $userInfo['username'] . "</td></tr>";
			$output .= "<tr><td><strong>" . $this->sodapop->language['profileEmail'] . "</strong> </td><td>" . $userInfo['email'] . "</td></tr>";
			$output .= "<tr><td><strong>" . $this->sodapop->language['profileBio'] . "</strong> </td><td>" . $userInfo['bio'] . "</td></tr>";
			$output	.= "</table></div>";	
			$output .= "<br /><br /><a href='" . $sthis->odapop->config['liveUrl'] . "user?action=logout'>" . $this->sodapop->language['profileLogout'] . "</a> |  <a href='" . $sthis->odapop->config['liveUrl'] . "user?action=edit'>" . $this->sodapop->language['profileEdit'] . "</a> | </a> <a href='" . $sthis->odapop->config['liveUrl'] . "user?action=delete'>" . $this->sodapop->language['profileDelete'] . "</a>";
		
		}
		
		return $output;
	}
	
	/*
	*  	buildEditProfile() 
	*/			
	public function buildEditProfile() {
	
		$cookie		= $this->sodapop->getCookie("sp_login");
		$userInfo	= $this->sodapop->database->getUserDataById($cookie);	

		if (!$cookie) {
		
			$output = "Please log in.";
		}
		
		else {
		
			$formFields = array ( 
							name,
							userName,
							email);

			$output	= $this->validator("Edit", $formFields);	
			
			if ($this->sodapop->string['update']) {
			
			if ($this->sodapop->string['dupEmail'] == '1') {
				$output	.= "<span class='alert'>" . $this->sodapop->language['emailUpdateNope'] . "<span><br/>";
			}	
			
			if ($this->sodapop->string['dupName'] == '1') {
				$output	.= "<span class='alert'>" . $this->sodapop->language['usernameUpdateNope'] . "<span><br/>";
			}
			
			}
				
			$output	.= "<h1>" . $this->sodapop->language['profileEditTitle'] . "</h1> ";	
			$output	.= "

						<div class='registrationForm'>
							<form name='Register' onsubmit='return validateFormOnSubmitEdit(this)' action='" . $this->sodapop->config['liveUrl'] . "user?action=update' method='post'>
								<table class='registrationTable'>
									<tr>
										<td><label for='name'> " . $this->sodapop->language['profileName'] . " </label></td>	
										<td><input type='text' name='name' value='" . $userInfo['name'] . "'></td>
									</tr>
									<tr>	
										<td><label for='username'> " . $this->sodapop->language['profileUsrName'] . "  </label></td>
										<td> <input type='text' name='username' value='" . $userInfo['username'] . "'> </td>
									</tr>
									<tr>							
										<td><label for='email'> " . $this->sodapop->language['profileEmail'] . " </label></td>
										<td> <input type='text' name='email' value='" . $userInfo['email'] . "'> </td>
									</tr>
									<tr>
										<td><label for='pwd'> " . $this->sodapop->language['profilePwd'] . "</label> </td>
										<td> <input type='text' name='pwd' value=''> </td>
									</tr>
									<tr>
										<td><label for='pwd'> " . $this->sodapop->language['profileBio'] . "</label> </td>
										<td> <textarea name='bio' rows='4' cols='50'>" . $userInfo['bio'] . "</textarea> </td>
									</tr>
									<tr>							 
										<td> <input name='redirect' type='hidden' value='" . $this->sodapop->config['liveUrl'] . "user'>
											<input name='id' type='hidden' value='" . $userInfo['id'] . "'>
											<input name='Submit' type='submit' value='" . $this->sodapop->language['editSubmit'] . "'> <a href='" . $this->sodapop->config['liveUrl'] . "user'>" . $this->sodapop->language['editCancel'] . "</a></td>
									</tr>
								</table>	
							
							</form>
						</div>";
						
		
							
		}
	
		return $output;		
	}
	
	/*
	*  	validator() builds the validation javascript based on the fields that are sent into
	*	it in a $fields array.  If a field is requested, then validator validates that 
	*	field.  You have to pass the $formName into it as well, so the JS method 
	*	can differentiate itself in case the validation srcipt appears mulitple times 
	*	on a page.
	*/				
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
	
	/*
	*  	getFields() parses the $fields array for validator() so that it knows which fields
	*	to validate. 
	*/		
	public function getFields($checkFields) {
	
	
		foreach ($checkFields as $i) {
			$fields[$i]	= '1';
		}
	
		return $fields;
	
	
	}
	
	
}
