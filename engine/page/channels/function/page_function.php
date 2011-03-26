<?php

class channels extends core{

	function __construct(){
	
		parent::database_connect();
	
	}
	
	function get_channel_statistics(){
	
		return parent::call_module("statistics", "channels");
		
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