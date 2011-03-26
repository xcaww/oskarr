<?php

class pagebits extends core{

	function __construct($moduleName, $moduleQuery, $moduleString, $moduleArray){
	
		$this->moduleData['name'] = $moduleName;
		$this->moduleData['query'] = $moduleQuery;
		$this->moduleData['string'] = $moduleString;
		$this->moduleData['array'] = $moduleArray;
	
	}
	
	function get_pagebits($pagebit){
	
		switch($pagebit){
		
			case "header":
			
				$pagebitData = "<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"en\">

	<head>
		<meta http-equiv=\"Content-Type\" content=\"application/xhtml+xmL; charset=iso-8859-1\" />
		<title>oskarr</title>
		<link href=\"" . dirname($_SERVER['SCRIPT_NAME']) . "/style.css\" rel=\"stylesheet\" type=\"text/css\" />
	</head>
	
	<body>
	
		<div id=\"header\" align=\"center\">
			<img src=\"" . dirname($_SERVER['SCRIPT_NAME']) . "/images/oskarr.png\" alt=\"oskarr\" />
		</div>	
	
		";
			
			break;
			case "footer":

			    $pagebitData = "
				
	</body>

</html>";

			break;
			case "execution":

				$pageTime = round((float) parent::execution_time() - (float) $this->moduleData['string'], 4);
			
				$pagebitData = "

		<br/>
		<p class=\"page_time\" align=\"center\">Generated page in {$pageTime} seconds</p>";
			
			break;
			
		}
		
		return $pagebitData;
	
	}
	
	function process_module(){
	
		parent::database_connect();
		$query = explode(", ", $this->moduleData['query']);
	
		foreach($query as $pagebit){

			$this->returnedData[$pagebit] = $this->get_pagebits($pagebit);
		
		}
		
		return $this->returnedData;
		
	}
	
}

?>