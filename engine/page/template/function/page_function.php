<?php

/*

	@ OSKARR (beta)
	@
	@ page_function
	@
	@ The functions described here and other scripts in the directory
	@ (if necessary) are used by the producers, acting as a backend
	@ for the generation of the page
	
*/

class template extends core{

	function __construct(){
	
		parent::database_connect();
	
	}
	
	function do_function(){
	
	//DO data collection, conversions, call other functions, remote library functions, etc...
	
	}
	
}
?>