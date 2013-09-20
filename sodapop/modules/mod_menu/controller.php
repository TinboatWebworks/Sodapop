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

class menu extends sodapop {

	public function menu() {

	}



	public function menuOutput($sodapop) {
		 
		$modOutput="
		<div class='menu'>
			<a href='./'>" . $sodapop->language['menu0'] . " </a> | <a href='monkeys'>" . $sodapop->language['menu1'] . " </a> | <a href='brick-wall'>" . $sodapop->language['menu2'] . "</a> | <a href='lamp'>" . $sodapop->language['menu3'] . "</a> 
		</div>";

		return $modOutput;
	}
}