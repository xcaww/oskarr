<?php

class log{
	
	function send_log($message){
	
		$time = time();
	
		mysql_query("
		INSERT INTO 
		log
		(time, message) 
		VALUES 
		('" . $time . "', '" . $message . "')
		");
		
	}
	
	function send_error_log($message){
	
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
		
			$loggedIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
			
		}else{ 
		
			$loggedIP = $_SERVER['REMOTE_ADDR'];
			
		}
	
		$time = time();
	
		mysql_query("
		INSERT INTO 
		error_log
		(time, ip, message) 
		VALUES 
		('" . $time . "', '" . $loggedIP . "', '" . $message . "')
		");	
		
	}
	
}

?>