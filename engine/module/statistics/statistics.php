<?php

class module extends core{

	function __construct($module){
	
		$this->moduleData = $module;
	
	}
	
	function get_statistics($statistic){
	
		$statisticResult = false;
	
		switch ($statistic){
	
			case "posts":
				
			break;
			case "channels":
			
				$result = parent::database_query("
				SELECT id
				FROM channels
				");
				
				if(mysql_num_rows($result)){
		
					$statisticResult = (string) mysql_num_rows($result);
					
				}

			break;
			default:
				parent::send_error_log("module error: failed statistic selection");
			break;
			
		}
		
		if($statisticResult != false){
	
			return $statisticResult;
			
		}else{
		
			parent::send_error_log("module error: failed statistic data");
			
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