<?php

class pagebits{

	function __construct($moduleName, $moduleQuery, $moduleString, $moduleArray){
	
		$this->moduleData['name'] = $moduleName;
		$this->moduleData['query'] = $moduleQuery;
		$this->moduleData['string'] = $moduleString;
		$this->moduleData['array'] = $moduleArray;
		$this->settings = get_settings();
	
	}

	function get_nav_items(){//TODO add conditions

		$result = database_query("
		SELECT *
		FROM nav
		");

		while($row = mysql_fetch_array($result)){

		    $nav[$row['id']]['name'] = $row['name'];
		    $nav[$row['id']]['address'] = $row['address'];

		}

		return $nav;

	}
	
	function get_pagebits($pagebit){
	
		switch($pagebit){
		
			case "header":

				$pagebitData = "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"en\">


	<head>
		<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\" />
		<meta http-equiv=\"cache-control\" content=\"no-cache\" />
		<meta http-equiv=\"content-language\" content=\"en-US\" />
		<title>" . get_settings("board_name") . "</title>
		<link href=\"" . dirname($_SERVER['SCRIPT_NAME']) . "/style.css\" rel=\"stylesheet\" type=\"text/css\" />
	</head>
	
	";
					
			break;
			case "logo":
			
				$pagebitData = "<body>
				
				<div id=\"header\" align=\"center\">
					<img src=\"" . dirname($_SERVER['SCRIPT_NAME']) . "/images/oskarr.png\" alt=\"oskarr\" />
				</div>	
			
				";
			
			break;
			case "footer":

			    $pagebitData = "<div id=\"footer\">

				    <p class=\"footer_oskarr\" align=\"center\">Blake &copy; 2011 - oskarr</p>
				
				</div>
				
	";
			    
			    $pagebitData .= "</body>

</html>";

			break;
			case "execution":

				$pageTime = round((float) execution_time() - (float) $this->moduleData['string'], 4);
			
				$pagebitData = "
		";
				include("./engine/module/pagebits/nav/generation_time.php");
			
			break;
			case "nav":

			    $header = call_module("pagebits", "header");
			    $pagebitData = $header['header'];
			    $this->get_nav_items();
			    $navItems = $this->get_nav_items();

			    foreach($navItems as $key => $navItem){

				if($this->moduleData['string'] == $navItem['name']){

				    $tabHTML[$key] = "<li id=\"active\"><a href=\"{$this->settings['board_url']}/{$navItem['address']}/\" id=\"active\">" . $navItem['name'] . "</a></li>";

				}else{

				   $tabHTML[$key] = "<li><a href=\"{$this->settings['board_url']}/{$navItem['address']}/\">" . $navItem['name'] . "</a></li>";

				}

			    }

			    $pagebitData .= "	<link href=\"{$this->settings['board_url']}/engine/module/pagebits/nav/style.css\" rel=\"stylesheet\" type=\"text/css\" />

<div id=\"footer_nav\">
		<div id=\"nav_container\">

			<div id=\"navigation\">

				<ul id=\"navlist\">

					";

			    foreach($tabHTML as $tab){

				$pagebitData .= $tab . "
				    ";

			    }

			    $pagebitData .= "

				</ul>

			</div>
</div>
		</div>";

				$logo = call_module("pagebits", "logo");
				$pagebitData .= $logo['logo'];
		
			break;
			
		}
		
		return $pagebitData;
	
	}
	
	function process_module(){
	
		database_connect();
		$query = explode(", ", $this->moduleData['query']);
	
		foreach($query as $pagebit){

			$this->returnedData[$pagebit] = $this->get_pagebits($pagebit);
		
		}
		
		return $this->returnedData;
		
	}
	
}

?>