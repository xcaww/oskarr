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

class channels extends core{

	function __construct(){
	
		parent::database_connect();
		$this->get_channels();
	
	}
	
	function get_channels(){
	
		$result = parent::database_query("
		SELECT *
		FROM channels
		");
		
		while($row = mysql_fetch_array($result)){
		
			$this->channels[$row['id']]['name'] = $row['name'];
			$this->channels[$row['id']]['address'] = $row['address'];
		
		}
	
	}
	
}
		
?>