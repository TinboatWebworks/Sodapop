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
    
    /*	I think I can take this out, but I'm leaving it commented out till I feel safe removing it all together.
     public function buildViewApp($data) {
     $language = $this->sodapop->language;
     $viewApp	= $data['appView'];
     return $viewApp;
     }
     */
    
    /*
     *  	buildRgstnForm() builds the registration form for new registrations
     */
    public function buildRgstnForm() {
        
        //require_once "./apps/user/assets/javascript/regFormValidation.php";
        
        $laguage	= extract($this->sodapop->language);
        $config		= extract($this->sodapop->config);
        
        $formFields = array(
            'name',
            'userName',
            'email',
            'pwd',
            'phone',
            'pwdConfirm');
        
        $form	= $this->validator("Register", $formFields);
        
        $form	.= "
            
			<div class='registrationForm'>
				<form name='Register' onsubmit='return validateFormOnSubmitRegister(this)' action='" . $liveUrl . "user?action=create' method='post'>
					<table class='registrationTable'>
						<tr>
							<td><label for='name'> " . $regName . " </label></td>
							<td><input type='text' name='name'></td>
						</tr>
						<tr>
							<td><label for='username'> " . $regUsrname . "(5-15 chars)  </label></td>
							<td> <input type='text' name='username'> </td>
						</tr>
						<tr>
							<td><label for='email'> " . $regEmail . " </label></td>
							<td> <input type='text' name='email'> </td>
						</tr>
						<tr>
							<td><label for='pwd'> " . $regPwd . "(7-15 chars)</label> </td>
							<td> <input type='password' name='pwd'> </td>
						</tr>
						<tr>
							<td><label for='pwdConfirm'> " . $regCnfPwd . " </label></td>
							<td> <input type='text' name='pwdConfirm'> </td>
						</tr>
						<tr>
							<td> <input name='redirect' type='hidden' value='" . $liveUrl . "user'>
								<input name='Submit' type='submit' value='" . $regSubmit . "'> </td>
						</tr>
					</table>
								    
				</form>
			</div>";
        
        return $form;
        
    }
    
    
    /*
     *  	buildRecoverPassword() builds the form that asks for users email address for password recovery
     */
    public function buildRecoverPassword() {
        
        // get the language and config date
        $laguage	= extract($this->sodapop->language);
        $config		= extract($this->sodapop->config);
        
        $form = "
            
			<div class='passwordRecover'>
				<form name='recover' action='" . $liveUrl . "user?action=tokenplease' method='post'>
					<table class='recoverTable'>
						<tr>
							<td><label for='name'> " . $emailForRecover . " </label></td>
							<td><input type='email' name='recoveryEmail'></td>
						</tr>
						<tr>
							<td>
								<input type='hidden' name='sendToken' value='yes'>
								<input name='Submit' type='submit' value='" . $submitForRecover . "'> </td>
						</tr>
					</table>
								    
				</form>
			</div>";
        
        return $form;
        
    }
    
    /*
     *  	buildAskForToken() builds the form that asks for the token that was emailed for password recovery
     */
    public function buildAskForToken() {
        
        // get the language and config date
        $laguage	= extract($this->sodapop->language);
        $config		= extract($this->sodapop->config);
        
        $form = "
            
			<div class='passwordRecoverToken'>
				<p class='tokenIntro'>" . $tokenSentRecover . "</p><br />
				<form name='recoverToken' action='" . $liveUrl . "user?action=checktoken' method='post'>
					<table class='recoverTable'>
						<tr>
							<td><label for='recoverTokan'> " . $tokenForRecover . " </label></td>
							<td><input type='text' name='token'></td>
						</tr>
						<tr>
							<td>
							    
								<input name='Submit' type='submit' value='" . $submittokenForRecover . "'> </td>
							</td>
						</tr>
					</table>
								    
				</form>
			</div>";
        
        return $form;
        
    }
    
    
    public function askForNewPassword($token) {
        
        
        // get the language and config date
        $laguage	= extract($this->sodapop->language);
        $config		= extract($this->sodapop->config);
        
        
        // This is where we tell the validator class what fields we want to validate
        $formFields = array (
            pwd,
            pwdConfirm
        );
        
        
        // loading the validator
        $output		= $this->validator("newPassword", $formFields);
        
        // The form
        $output 	.= "
            
			<div class='askForNewPassword'>
				<p class='tokenIntro'>" . $askForNewPassword . "</p><br />
				<form name='newPassword' onsubmit='return validateFormOnSubmitnewPassword(this)' action='" . $liveUrl . "user?action=updatePassword' method='post'>
					<table class='recoverTable'>
						<tr>
							<td><label for='recoverTokan'> " . $passwordLabel . " </label></td>
							<td><input type='password' name='pwd'></td>
						</tr>
						<tr>
							<td><label for='recoverTokan'> " . $passwordLabelConfirm . " </label></td>
							<td><input type='password' name='pwdConfirm'></td>
						</tr>
						<tr>
							<td>
								<input type='hidden' name='token' value='" . $token . "'>
								<input type='hidden' name='setPass' value='yes'>
								<input name='Submit' type='submit' value='" . $submittokenForRecover . "'> </td>
							</td>
						</tr>
					</table>
								    
				</form>
			</div>";
        
        return $output;
        
    }
    
    /*
     *  	buildProfile() builds the profile page.  It's super simple here, but could be expanded
     *	by greated an html.profile.php file and requiring it, or something like that, to
     *	make it more fancy for your own purposes.
     */
    public function buildProfile() {
        //	    print_r($this->sodapop->language);
        $output       = "";
        $cookie		= $this->sodapop->getCookie("sp_login");
        $userInfo	= $this->sodapop->getUserDataById($cookie);
        $language	= extract($this->sodapop->language, EXTR_PREFIX_ALL, "LANG");
        $config	    = extract($this->sodapop->config, EXTR_PREFIX_ALL, "CONFIG");
        
        
        if (!empty($userInfo)) {
            $userInfo	= extract($userInfo, EXTR_PREFIX_ALL, "USERINFO");
        }
        
        // If we don't find a cookie, let's ask them to log in
        if (!$cookie) {
            
            $output = $LANG_pleaseLogIn;
        }
        
        // If we do find a cookie...
        else {
            
            //Check their uers level to see how much access they have
            $id = $this->sodapop->getCookie("sp_login");
            /*	*/
            //Allow them to manage users if their user level is greater than 5
            if ($this->sodapop->checkAccessLevel($id) >= 5) {
                $output	.= "<a href='" . $CONFIG_liveUrl . "user?action=mangeusers'>Manage Users</a>";
            }
            
            
            // Build the users profile view
            $output	.= "<h1>" . $LANG_profileTitle . "</h1> ";
            $output	.= "<div class='profileData'><table>";
            $output .= "<tr><td><strong>" . $LANG_profileName . "</strong> </td><td>" . $USERINFO_name . "</td></tr>";
            $output .= "<tr><td><strong>" . $LANG_profileUsrName . "</strong> </td><td>" . $USERINFO_username . "</td></tr>";
            $output .= "<tr><td><strong>" . $LANG_profileEmail . "</strong> </td><td>" . $USERINFO_email . "</td></tr>";
            $output .= "<tr><td><strong>" . $LANG_profileBio . "</strong> </td><td>" . $USERINFO_bio . "</td></tr>";
            $output	.= "</table></div>";
            $output .= "<br /><br /><a href='" . $CONFIG_liveUrl . "user?action=logout'>" . $LANG_profileLogout . "</a> |  <a href='" . $CONFIG_liveUrl . "user?action=edit'>" . $LANG_profileEdit . "</a> | </a> <a href='" . $CONFIG_liveUrl . "user?action=delete'>" . $LANG_profileDelete . "</a>";
            
        }
        
        return $output;
    }
    
    /*
     *  	buildEditProfile() creates the form that lets the user update their user info
     */
    public function buildEditProfile() {
        
        $cookie		= $this->sodapop->getCookie("sp_login");
        $userInfo	= $this->sodapop->getUserDataById($cookie);
        $userInfo	= extract($userInfo, EXTR_PREFIX_ALL, "USERINFO");
        $laguage	= extract($this->sodapop->language, EXTR_PREFIX_ALL, "LANG");
        $config	= extract($this->sodapop->config, EXTR_PREFIX_ALL, "CONFIG");
        
        // Let's make sure they are logged in, just to be safe
        if (!$cookie) {
            
            $output = "Please log in.";
        }
        
        //If they are logged in...
        else {
            
            // Set up the fields to send to the validator
            $formFields = array (
                'name',
                'userName',
                'email'
            );
            
            // Build the validator
            $output	= $this->validator("Edit", $formFields);
            
            // if the URL is telling us to update
            if ( isset($this->sodapop->string['update'])) {
                
                // Make sure the email isn't already in use
                if ($this->sodapop->string['dupEmail'] == '1') {
                    $output	.= "<span class='alert'>" . $LANG_emailUpdateNope . "<span><br/>";
                }
                
                // And also that the name is unique
                if ($this->sodapop->string['dupName'] == '1') {
                    $output	.= "<span class='alert'>" . $LANG_usernameUpdateNope . "<span><br/>";
                }
                
            }
            
            // Ok, now lets build the form to give then to update their profile
            
            if (!isset($liveURL)) {$liveUrl = "";}
            
            $output	.= "<h1>" . $LANG_profileEditTitle . "</h1> ";
            $output	.= "
                
						<div class='registrationForm'>
							<form name='Register' onsubmit='return validateFormOnSubmitEdit(this)' action='" . $CONFIG_liveUrl . "user?action=update' method='post'>
								<table class='registrationTable'>
									<tr>
										<td><label for='name'> " . $LANG_profileName . " </label></td>
										<td><input type='text' name='name' value='" . $USERINFO_name . "'></td>
									</tr>
									<tr>
										<td><label for='username'> " . $LANG_profileUsrName . "  </label></td>
										<td> <input type='text' name='username' value='" . $USERINFO_username . "'> </td>
									</tr>
									<tr>
										<td><label for='email'> " . $LANG_profileEmail . " </label></td>
										<td> <input type='text' name='email' value='" . $USERINFO_email . "'> </td>
									</tr>
									<tr>
										<td><label for='pwd'> " . $LANG_profilePwd . "</label> </td>
										<td> <input type='text' name='pwd' value=''> </td>
									</tr>
									<tr>
										<td><label for='pwd'> " . $LANG_profileBio . "</label> </td>
										<td> <textarea name='bio' rows='4' cols='50'>" . $USERINFO_bio . "</textarea> </td>
									</tr>
									<tr>
										<td> <input name='redirect' type='hidden' value='" . $liveUrl . "user'>
											<input name='id' type='hidden' value='" . $USERINFO_id . "'>
											<input name='Submit' type='submit' value='" . $LANG_editSubmit . "'> <a href='" . $CONFIG_liveUrl . "user'>" . $LANG_editCancel . "</a></td>
									</tr>
								</table>
											    
							</form>
						</div>";
            
            
            
        }
        
        return $output;
    }
    
    /*
     * buildUserList() will get the data of each user and compile the view output for the Manage Users
     * view.  ## This view building should really be moved to te view.php object, and the logic probably
     * moved to the controller, but it's hear for now
     */
    public function buildUserList($usersData) {
        
        foreach ($usersData as $userData) {
            ;
            $userData	=	extract($userData);
            
            if(empty($output)){$output ="";}
            
            $output	.="<form name='Manage' onsubmit='return validateFormOnSubmitmanageUsers(this)' action='" . $this->sodapop->config['liveUrl'] . "user?action=mangeusers&do=update' method='post'>";
            $output	.="<tr>";
            $output	.="<td>" .$id . "</td>";
            $output	.="<td><input type='text' name='name' value='" . $name . "'></td>";
            $output	.="<td><input type='text' name='email' value='" . $email . "'></td>";
            $output	.="<td><input type='text' name='username' value='" . $username . "'></td>";
            $output	.="<td><input type='text' name='pwd' value=''></td>";
            $output	.="<td><select name='accessLevel'><option>" . $accessLevel . "</option><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option><option>6</option><option>7</option><option>8</option><option>9</option><option>11</option></td>";
            $output	.="<td><input name='id' type='hidden' value='" .$id . "'><input name='Submit' type='submit' value='Update'></form></td>";
            $output	.="<form name='Delete' action='" . $this->sodapop->config['liveUrl'] . "user?action=mangeusers&do=delete' method='post'>";
            $output	.="<td><input name='id' type='hidden' value='" .$id . "'><input name='Submit' type='submit' value='Delete'></form></td>";
            $output	.="</tr>";
            $output	.="";
        }
        
        return $output;
        
    }
    
    /*
     *  	listUsers() is going to build the list of users for the Manage Users view.
     */
    public function listUsers($userList) {
        
        if(empty($output)){$output ="";}
        
        // Tell the validator which fields we want to validate
        $formFields = array (
            'name',
            'userName',
            'email',
            'password');
        
        // build the validation script
        $output	.= $this->validator("manageUsers", $formFields);
        
        // And build the list of users.
        $output	.= "<table width='100%'>
						<tr>
							<td>ID</td>
							<td>Name</td>
							<td>Email</td>
							<td>User Name</td>
							<td>Password</td>
							<td>Access Level</td>
							<td></td>
							<td></td>
						</tr>"
            . $userList . "
						<tr>
							<td><form name='Manage' onsubmit='return validateFormOnSubmitmanageUsers(this)' action='" . $this->sodapop->config['liveUrl'] . "user?action=mangeusers&do=new' method='post'></td>
							<td><input type='text' name='name' value=''></td>
							<td><input type='text' name='email' value=''></td>
							<td><input type='text' name='username' value=''></td>
							<td><input type='text' name='pwd' value=''></td>
							<td><input type='text' name='accessLevel' value='' size='2'></td>
							<td><input type='submit' name='add' value='Add'></td>
							<td></td>
						</tr>
					</table>";
            
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
        
        if (isset($fields['name'])) {
            if ($fields['name'] == '1') {
                
                $validator .= '
					reason += validateName(theForm.name);';
            }
        }
        
        if (isset($fields['userName'])) {
            if ($fields['userName'] == '1') {
                $validator .= '
					reason += validateUsername(theForm.username);';
            }
        }
        
        if (isset($fields['pwd'])) {
            if ($fields['pwd'] == '1') {
                $validator .= '
					reason += validatePassword(theForm.pwd);';
            }
        }
        
        if (isset($fields['pwdConfirm'])) {
            if ($fields['pwdConfirm'] == '1') {
                $validator .= '
					reason += validatePasswordConfirm(theForm.pwdConfirm, theForm.pwd);';
            }
        }
        
        if (isset($fields['email'])) {
            if ($fields['email'] == '1') {
                $validator .= '
					reason += validateEmail(theForm.email);';
            }
        }
        
        if (isset($fields['phone'])) {
            if ($fields['phone'] == '1') {
                $validator .= '
					reason += validatePhone(theForm.phone);';
            }
        }
        
        
        $laguage	= extract($this->sodapop->language, EXTR_PREFIX_ALL, "LANG");
        
        $validator .= '
            
				if (reason != "") {
					alert("' . $LANG_validateError . '" + reason);
					return false;
				}
					    
				  return true;
				}
					    
				function validateEmpty(fld) {
					var error = "";
					    
					if (fld.value.length == 0) {
						fld.style.background = \'Yellow\';
						error = "' . $LANG_validateReqField . '"
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
						error = "'. $LANG_validateNoName .'";
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
						error = "' . $LANG_validateNoName	. '";
					} else if ((fld.value.length < 5) || (fld.value.length > 15)) {
						fld.style.background = "Yellow";
						error = "' . $LANG_validateUsrNmLgth . '";
					} else if (illegalChars.test(fld.value)) {
						fld.style.background = "Yellow";
						error = "' . $LANG_validateUsrIllChars . '";
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
						error = "' . $LANG_validateNoPwd . '";
					} else if ((fld.value.length < 7) || (fld.value.length > 15)) {
						error = "' . $LANG_validatePwdLgth . '";
						fld.style.background = \'Yellow\';
					} else if (illegalChars.test(fld.value)) {
						error = "' . $LANG_validatePwdIllChrs . '";
						fld.style.background = \'Yellow\';
					} else if (!((fld.value.search(/(a-z)+/)) && (fld.value.search(/(0-9)+/)))) {
						error = "' . $LANG_validatePwdOneNmrl . '";
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
						error = "' . $LANG_validateNoCnfPwd . '";
					} else if (fld.value != chk.value) {
						error = "' . $LANG_validatePwdNoMch . '";
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
						error = "' . $LANG_validateNoEml	. '";
					} else if (!emailFilter.test(tfld)) {              //test email for illegal characters
						fld.style.background = \'Yellow\';
						error = "' . $LANG_validateVldEml . '";
					} else if (fld.value.match(illegalChars)) {
						fld.style.background = \'Yellow\';
						error = "' . $LANG_validateEmlIllChrs . '";
					} else {
						fld.style.background = \'White\';
					}
					return error;
				}
						    
				function validatePhone(fld) {
					var error = "";
					var stripped = fld.value.replace(/[\(\)\.\-\ ]/g, \'\');
						    
				   if (fld.value == "") {
						error = "' . $LANG_validateNoPhn	. '";
						fld.style.background = "Yellow";
					} else if (isNaN(parseInt(stripped))) {
						error = "' . $LANG_validatePhnIllChrs . '";
						fld.style.background = "Yellow";
					} else if (!(stripped.length == 10)) {
						error = "' . $LANG_validatePhnLgth . '";
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
