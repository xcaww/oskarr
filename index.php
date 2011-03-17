<?php
/*
	@ OSKARR (beta)
	@ Developed by xCore
	@ Current Stage: in beginning of core development
	@ Version: none...
	
	
	# Instructions
	
	# Operation of the index is only available through url variables.
	# Example: index.php?post=1
	# Example: index.php?channel=rage
	# Current structure and functionality (including minimum security) is very unstable...
	
	# Without a connected mySQL database, this will not function.
	# Details on the database structure are yet to be released...
	
*/


//load core function library + logger
require("./engine/core.php");
require("./engine/database.class.php");

//Let's roll...
$timer_start = execution_time(); 
$database = new database();
show_header();
$database->connect_database();

//GET i VAR
if(isset($_GET['i'])){

	if(ctype_digit($_GET['i'])){
	
		$URL_i = (string) $_GET['i'];
		
	}else{
	
		$URL_i = "0";
		
	}
	
}else{

	$URL_i = "0";
	
}

//GET page VAR
if(isset($_GET['page'])){

	if(ctype_alnum($_GET['page'])){

		$URL_page = (string) $_GET['page'];
		require("./engine/gen/gen_page.php");
		$pageGen = new generatePage($URL_page, $URL_i);
		
	}
//GET post VAR	
}elseif(isset($_GET['post'])){

	if(ctype_alnum($_GET['post'])){

		$URL_post = (string) $_GET['post'];
		require("./engine/gen/gen_thread.php");
		generate_thread($URL_post);
		
	}
//GET channel VAR	
}elseif(isset($_GET['channel'])){

	if(ctype_alnum($_GET['channel'])){

		$URL_channel = (string) $_GET['channel'];
		require("./engine/gen/gen_channel.php");
		generate_channel($URL_i, $URL_channel);
		
	}
//GET handle VAR	
}elseif(isset($_GET['handle'])){

	if(ctype_alnum($_GET['handle'])){

		$URL_handle = (string) $_GET['handle'];
		//Needs to be written...
		
	}
	
}


//end execution timer
echo "<br/><p class=\"page_time\" align=\"center\">Generated page in " . round(execution_time() - $timer_start, 3) . " seconds</p></html>";    
	
	
?>