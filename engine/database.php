<?php

class database extends core{

	function connect_database(){
	
		$this->connectionLink = mysql_connect("localhost", "root", "rscbU");
		
		if($this->connectionLink){
		
			mysql_select_db("oskarr");
			
		}else{
		
			parent::send_error_log("Could not create a connection the to database");
			
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
		
	