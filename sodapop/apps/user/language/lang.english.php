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

$language['didPass']		.= "Successfully logged in. ";
$language['didNotPass']		= "Password Does Not Match.  ";
$language['thankYou']		= "Thank you for attempting to log in.";
$language['newUser']		= "Welcome - lets create your account!";

$language['tempName']		= "Template Name";
$language['whatApp']		= "App Name: ";
$language['pleaseLogIn']	= "Please log in.";

// Registration Form Language
$language['regName']	= "Name: ";
$language['regUsrname']	= "Username: ";
$language['regEmail']	= "Email: ";
$language['regPwd']		= "Password: ";
$language['regCnfPwd']	= "Confirm Password: ";
$language['regSubmit']	= "Register";
$language['editSubmit']	= "Update";
$language['noUpdate']	= "That email address or username is already in use.";
$language['emailUpdateNope']	= "That email address is already in use.";
$language['usernameUpdateNope']	= "That user name address is already in use.";
$language['profileEditTitle']	= "Edit Profile:";

// Registration For Profile Page
$language['profileTitle']	= "Profile:";
$language['profileUsrName']	= "Your User Name: ";
$language['profileName']	= "Your Name: ";
$language['profileEmail']	= "Your Email Address: ";
$language['profileLogout']	= "Log Out";
$language['profileEdit']	= "Edit Info";
$language['profileDelete']	= "Delete Account";
$language['profilePwd']		= "Your Password:";
$language['profileBio']		= "Biography:";
$language['editCancel']		= "Cancel";
$language['passwordUpdated']= "Your password has been updated.  You may now log in with your new password.";

// Recover Password Language
$language['emailForRecover']			= "Enter your email address:";
$language['tokenForRecover']			= "Enter the token:";
$language['tokenSentRecover']			= "An email has been sent with a token";
$language['submitForRecover']			= "Submit";
$language['submittokenForRecover']		= "Submit";
$language['NoMatchingAccount']			= "No Matching Account with that email address.";
$language['askForNewPassword']			= "Token Accepted.  Please enter your new password.";
$language['passwordLabel']				= "Your New Password: ";
$language['passwordLabelConfirm']		= "Confirm Password: ";
$language['updatingPasswordMessage']	= "Updating password... [bleep] [bleep] [bleep]<br />";
$language['youDontHaveAToken']			= "Are you trying to recover yourpassword?  If so, <a href='/user?action=recover'>try here</a>.";
$language['cannotView']					= "You cannot view this page.";

// Validator errors (Not using these yet...)
$language['validateError']			= "Some fields need correction:\n\n";
$language['validateReqField']		= "The required field has not been filled in.\n";
$language['validateNoName']			= "You didn\'t enter your name.\n";
$language['validateUsrIllChars']	= "The username contains illegal characters.\n";
$language['validateNoUsrNm']		= "You didn\'t enter a username.\n";
$language['validateUsrNmLgth']		= "The username is the wrong length.\n";
$language['validateUsrNmIllChrs']	= "The username contains illegal characters.\n";
$language['validateNoPwd']			= "You didn\'t enter a password.\n";
$language['validatePwdLgth']		= "The password is the wrong length. \n";
$language['validatePwdIllChrs']		= "The password contains illegal characters.\n";
$language['validatePwdOneNmrl']		= "The password must contain at least one numeral.\n";
$language['validateNoCnfPwd']		= "You didn\'t enter a confirmation password.\n";
$language['validatePwdNoMch']		= "The passwords do not match. \n";
$language['validateNoEml']			= "You didn\'t enter an email address.\n";
$language['validateVldEml']			= "Please enter a valid email address.\n";
$language['validateEmlIllChrs']		= "The email address contains illegal characters.\n";
$language['validateNoPhn']			= "You didn\'t enter a phone number. \n ";
$language['validatePhnIllChrs']		= "The phone number contains illegal characters. \n";
$language['validatePhnLgth']		= "The phone number is the wrong length. Make sure you included an area code.\n";

$this->language			=	$language;

?>