<?php
/*

 * OSKARR (beta)
 * Developed by xCore
 * Current Stage: in beginning of core development
 * Version: none...

 * Instructions

 * Operation of the index is only available through url variables.
 * Example: index.php?post=1
 * Example: index.php?channel=rage
 * Current structure and functionality (including minimum security) is very unstable...

 * Without a connected mySQL database, this will not function.
 * Details on the database structure are yet to be released...
	
*/

//load core function library + settings + database class
include("./engine/core.php");
include("./engine/settings.php");
include("./engine/database.php");
include("./engine/page.php");

//Let's roll...
$execution_start = execution_time();

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

	    if(ctype_alnum($_GET['page'])){//TODO add unknown page error handler

		    $URL_page = (string) $_GET['page'];
		    $page = new generatePage($URL_page, $URL_i);

	    }
    //GET post VAR
    }elseif(isset($_GET['post'])){

	    if(ctype_alnum($_GET['post'])){

		    $URL_post = (string) $_GET['post'];
		    $page = new generatePage("post", $URL_post);

	    }
    //GET channel VAR
    }elseif(isset($_GET['channel'])){

	    if(ctype_alnum($_GET['channel'])){

		    $URL_channel = (string) $_GET['channel'];
		    $page = new generatePage("channel", $URL_channel, $URL_i);

	    }
    //GET handle VAR
    }elseif(isset($_GET['handle'])){

	    if(ctype_alnum($_GET['handle'])){

		    $URL_handle = (string) $_GET['handle'];
		    //TODO Needs to be written...

	    }

    }


//execution time
$execution_time = call_module("pagebits", "execution", $execution_start);
echo $execution_time['execution'];

//close page
$footer = call_module("pagebits", "footer");
echo $footer['footer'];
?>