<?php

class core{

	function database_connect(){
	
		$this->database = new database();
		$this->database->connect_database();
		
	}

	function database_query($databaseQuery){
	
		return $this->database->query($databaseQuery);
		
	}
	
	function generate_page($URL_page, $URL_query, $URL_i = false){
	
		require("./engine/page.php");
		$pageGen = new generatePage($URL_page, $URL_query, $URL_i);
		
	}
	
	function get_base_dir(){
	
		echo dirname($_SERVER['SCRIPT_NAME']);
		
	}
	
	function require_file_once($fileRequest){
	
		if(file_exists($fileRequest)){
		
			require_once($fileRequest);
			
		}else{

			$this->send_error_log("require once: " . $fileRequest);
			
		}
		
	}
	
	function call_module($module){//TODO, add a modules table to database
		
		$this->require_file_once("./engine/module/" . $module['moduleName'] . "/" . $module['moduleName'] . ".php");
		
		$this->module = new $module['moduleName']($module);
		$moduleData = $this->module->process_module();
		
		return $moduleData;
	}

	function execution_time(){ 
	
		list ($msec, $sec) = explode(' ', microtime()); 
		$execution_time = (float)$msec + (float)$sec; 
		return $execution_time; 
		
	} 	
	
	function send_log($message){
	
		$time = time();
	
		$this->database_query("
		INSERT INTO 
		log
		(time, message) 
		VALUES 
		('" . $time . "', '" . $message . "')
		");
		
	}
	
	function send_error_log($errorMessage){
	
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
		
			$loggedIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
			
		}else{ 
		
			$loggedIP = $_SERVER['REMOTE_ADDR'];
			
		}
	
		$time = time();
	
		$this->database_query("
		INSERT INTO 
		error_log
		(time, ip, message) 
		VALUES 
		('" . $time . "', '" . $loggedIP . "', '" . addslashes($errorMessage) . "')
		")or die(mysql_error());
		
		
		echo "<p align=\"center\">A fatal error has occured.</p><p align=\"center\"><a href=\"javascript:javascript:history.go(-1)\">Go Back</a></p>";
		exit();
		
	}	
	
	function get_channel($channelAddress = false, $postID = false){
	
		if($channelAddress != false){
		
			$result = $this->database_query("
			SELECT *
			FROM channels
			WHERE address = '" . $channelAddress . "'
			LIMIT 1
			");
		
		}elseif($postID != false){
		
			$result = $this->database_query("
			SELECT channel
			FROM posts
			WHERE id = '" . $postID . "'
			LIMIT 1
			");
			
			while($row = mysql_fetch_array($result)){
			
				$channelID = $row['channel'];
				
			}
			
			mysql_free_result($result);
			unset($row);
		
			$result = $this->database_query("
			SELECT *
			FROM channels
			WHERE id = '" . $channelID . "'
			LIMIT 1
			");
		
		}
	
		while($row = mysql_fetch_array($result)){
		
			$found_channel['id'] = $row['id'];
			$found_channel['name'] = $row['name'];
			$found_channel['address'] = $row['address'];
			
		}

		mysql_free_result($result);
		
		//hmmm...
		return @$found_channel;
		
	}
	
}
	
?>