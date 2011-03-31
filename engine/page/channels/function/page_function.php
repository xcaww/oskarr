<?php

class channels{

	function __construct(){
	
		database_connect();
		$nav = call_module("pagebits", "nav", "Channels");
		echo $nav['nav'];
	
	}
	
	function get_channel_statistics(){
	
		return call_module("statistics", "channels");
		
	}
	
	function get_channels(){
	
		$result = database_query("
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