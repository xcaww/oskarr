<?php

class channels extends core{

	function __construct(){
	
		parent::database_connect();
	
	}
	
	function get_channel_statistics(){
	
		$module['moduleName'] = "statistics"; 
		$module['moduleQuery'] = "channels"; //statistics pattern example: "channels, posts, most_active_channel" will be handled by a switch case that determines the result for the string piece given -> explode(", " $query)
		return parent::call_module($module);
		
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
		
		return $this->channels;
	
	}
	
}
		
?>