<?php

class database extends core{

	function connect_database(){
	
		$this->connectionLink = mysql_connect("localhost", "root", "pass");
		
		if($this->connectionLink){
		
			mysql_select_db("oskarr");
			
		}else{
		
			parent::send_error_log("Could not create a connection to the database");
			
		}
		
	}
	
	function query($databaseQuery){
	
		$query = mysql_query($databaseQuery);
		
		if(!$query){
		
			$errorMessage = (string) "query: " . mysql_error();
			parent::send_error_log($errorMessage);
				
		}else{
			
			return $query;
			
		}
			
	}
	
}
		
	