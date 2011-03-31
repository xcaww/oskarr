<?php

class statistics{

	function __construct($moduleName, $moduleQuery, $moduleString, $moduleArray){
	
		$this->moduleData['name'] = $moduleName;
		$this->moduleData['query'] = $moduleQuery;
	
	}
	
	function get_statistics($statistic){
	
		$statisticResult = false;
		
		/*if(substr($statistic, 0, 1) == "@"){//@variable_variable_variable etc...
		
			$splitStatisticVars = explode("_", substr($statistic, 0, 1));

		}*/
	
		switch($statistic){
	
			case "posts":
			
				$result = database_query("
				SELECT id
				FROM posts
				");
				
			break;
			case "channels":
			
				$result = database_query("
				SELECT id
				FROM channels
				");

			break;
			
		}
		
		if(mysql_num_rows($result)){
		
			return (string) mysql_num_rows($result);
					
		}else{
		
			send_error_log("module error: Statistics -> failed statistic data");
			
		}
	
	}
	
	function process_module(){
	
		database_connect();
		$query = explode(", ", $this->moduleData['query']);
	
		foreach($query as $statistic){

			$this->returnedData[$statistic] = $this->get_statistics($statistic);
		
		}
		
		return $this->returnedData;
		
	}
	
}

?>