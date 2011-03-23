<?php

class statistics extends core{

	function __construct($module){
	
		$this->moduleData = $module;
	
	}
	
	function get_statistics($statistic){
	
		$statisticResult = false;
		
		/*if(substr($statistic, 0, 1) == "@"){//@variable_variable_variable etc...
		
			$splitStatisticVars = explode("_", substr($statistic, 0, 1));

		}*/
	
		switch($statistic){
	
			case "posts":
			
				$result = parent::database_query("
				SELECT id
				FROM posts
				");
				
			break;
			case "channels":
			
				$result = parent::database_query("
				SELECT id
				FROM channels
				");

			break;
			
		}
		
		if(mysql_num_rows($result)){
		
			return (string) mysql_num_rows($result);
					
		}else{
		
			parent::send_error_log("module error: Statistics -> failed statistic data");
			
		}
	
	}
	
	function process_module(){
	
		parent::database_connect();
		$query = explode(", ", $this->moduleData['moduleQuery']);
	
		foreach($query as $statistic){

			$this->returnedData[$statistic] = $this->get_statistics($statistic);
		
		}
		
		return $this->returnedData;
		
	}
	
}

?>