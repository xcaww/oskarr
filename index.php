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
require("./engine/database.php");

//Let's roll...
$core = new core();
$timer_start = $core->execution_time(); 
$core->show_header();
$core->database_connect();

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
		$core->generate_page($URL_page, $URL_i);
		
	}
//GET post VAR	
}elseif(isset($_GET['post'])){

	if(ctype_alnum($_GET['post'])){

		$URL_post = (string) $_GET['post'];
		$core->generate_page("post", $URL_post);
		
	}
//GET channel VAR	
}elseif(isset($_GET['channel'])){

	if(ctype_alnum($_GET['channel'])){

		$URL_channel = (string) $_GET['channel'];
		$core->generate_page("channel", $URL_channel, $URL_i);
		
	}
//GET handle VAR	
}elseif(isset($_GET['handle'])){

	if(ctype_alnum($_GET['handle'])){

		$URL_handle = (string) $_GET['handle'];
		//Needs to be written...
		
	}
	
}


//end execution timer, close page tags
echo "

		<br/>
		<p class=\"page_time\" align=\"center\">Generated page in " . round($core->execution_time() - $timer_start, 3) . " seconds</p>
		
	</body>
	
</html>";    
	
	
?>