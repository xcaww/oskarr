<?php

	function execution_time(){ 
	
		list ($msec, $sec) = explode(' ', microtime()); 
		$execution_time = (float)$msec + (float)$sec; 
		return $execution_time; 
		
	} 	
	
	function connect_database(){
	
		mysql_connect("localhost", "root", "rscbU")
		or die(mysql_error());
		mysql_select_db("oskarr");
		
	}
	
	function show_header(){
	
	echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"en\">

	<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
		<title>oskarr</title>
		<link href=\"style.css\" rel=\"stylesheet\" type=\"text/css\" />
	</head>
	
	<body>
	
		<div id=\"header\" align=\"center\">
				<img src=\"images/oskarr.png\" alt=\"oskarr\" />
		</div>	
	
		";
	
	}
	
	function get_channel($channelAddress = false, $postID = false){
	
	if($channelAddress != false){
	
		$result = mysql_query("
		SELECT *
		FROM channels
		WHERE address = '" . $channelAddress . "'
		LIMIT 1
		");
	
	}elseif($postID != false){
	
		$result = mysql_query("
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
	
		$result = mysql_query("
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
	
?>