<?php

	function database_connect(){
	
		$coreDatabase = new database();
		$coreDatabase->connect_database();
		return $coreDatabase;

	}

	function database_query($databaseQuery){
	    
		$coreDatabase = database_connect();
		return $coreDatabase->query($databaseQuery);
		
	}
	
	function generate_page($URL_page, $URL_query, $URL_i = false){
	
		$corePageGen = new generatePage($URL_page, $URL_query, $URL_i);
		
	}

	function get_settings($coreSettings = false){

	   $coreBoardSettings = new boardSettings();

	   if($coreSettings != false){
	       
	       $coreSettingsQuery = explode(", ", $coreSettings);

	   }else{

	       $coreSettingsQuery = false;

	   }

	    if(sizeof($coreSettingsQuery) > 1){

		foreach($coreSettingsQuery as $setting){

		    $coreSetting[$setting] = (string) $coreBoardSettings->settings[$setting];

		}

		return $coreSetting;

	    }elseif(($coreSettingsQuery != false)){

		return $coreBoardSettings->settings[$coreSettings];

	    }elseif(($coreSettingsQuery == false)){

		return $coreBoardSettings->settings;

	    }else{

		return $coreBoardSettings->settings;

	    }

	}
	
	function get_base_dir(){
	
		echo dirname($_SERVER['SCRIPT_NAME']);
		
	}
	
	function require_file_once($fileRequest){
	
		if(file_exists($fileRequest)){
		
			require_once($fileRequest);
			
		}else{

			send_error_log("require once: " . $fileRequest);
			
		}
		
	}
	
	function call_module($coreModuleName, $coreModuleQuery, $coreModuleString = false, $coreModuleArray = false){//TODO add a modules table to database

		require_file_once("./engine/module/" . $coreModuleName . "/" . $coreModuleName . ".php");
		$coreModule = new $coreModuleName($coreModuleName, $coreModuleQuery, $coreModuleString, $coreModuleArray);
		$coreModuleData = $coreModule->process_module();
		return $coreModuleData;

	}

	function execution_time(){ 
	
		list ($msec, $sec) = explode(' ', microtime()); 
		$coreExecutionTime = (float)$msec + (float)$sec;
		return $coreExecutionTime;
		
	} 	
	
	function send_log($coreMessage){
	
		$coreTime = time();
	
		database_query("
		INSERT INTO 
		log
		(time, message) 
		VALUES 
		('" . $coreTime . "', '" . $coreMessage . "')
		");
		
	}
	
	function send_error_log($coreErrorMessage){
	
		if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
		
			$coreLoggedIP = $_SERVER['HTTP_X_FORWARDED_FOR'];
			
		}else{ 
		
			$coreLoggedIP = $_SERVER['REMOTE_ADDR'];
			
		}
	
		$coreTime = time();
	
		database_query("
		INSERT INTO 
		error_log
		(time, ip, message) 
		VALUES 
		('" . $coreTime . "', '" . $coreLoggedIP . "', '" . addslashes($coreErrorMessage) . "')
		")or die(mysql_error());
		
		
		echo "<p align=\"center\">A fatal error has occured.</p><p align=\"center\"><a href=\"javascript:javascript:history.go(-1)\">Go Back</a></p>";
		exit();
		
	}	
	
	function get_channel($coreChannelAddress = false, $corePostID = false){
	
		if($coreChannelAddress != false){
		
			$result = database_query("
			SELECT *
			FROM channels
			WHERE address = '" . $coreChannelAddress . "'
			LIMIT 1
			");
		
		}elseif($corePostID != false){
		
			$result = database_query("
			SELECT channel
			FROM posts
			WHERE id = '" . $corePostID . "'
			LIMIT 1
			");
			
			while($row = mysql_fetch_array($result)){
			
				$coreChannelID = $row['channel'];
				
			}
			
			mysql_free_result($result);
			unset($row);
		
			$result = database_query("
			SELECT *
			FROM channels
			WHERE id = '" . $coreChannelID . "'
			LIMIT 1
			");
		
		}
	
		while($row = mysql_fetch_array($result)){
		
			$coreFoundChannel['id'] = $row['id'];
			$coreFoundChannel['name'] = $row['name'];
			$coreFoundChannel['address'] = $row['address'];
			
		}

		mysql_free_result($result);
		
		return $coreFoundChannel;
		
	}
	
?>