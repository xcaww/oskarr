<?php

function validate_query($pageIdentifier, $pageQuery){

	if(ctype_alnum($pageIdentifier) == true && is_integer($pageQuery) == true && strlen($pageIdentifier) < 33 && $pageQuery < 33){
	
		return true;
		
	}else{
	
		return false;
		
	}

}

function find_page($page){

	

	if(is_integer($page)){
	
		$page = mysql_query("
		SELECT *
		FROM pages
		WHERE id = '" . $page . "'
		");
	
	}elseif(is_string($page)){
	
		$page = mysql_query("
		SELECT *
		FROM pages
		WHERE address = '" . $page . "'
		");	
	
	}else{
	
		return false;
		
	}
	
	while($row = mysql_fetch_array($page)){

		$pageDetails['id'] = $row['id'];
		$pageDetails['name'] = $row['name'];
		$pageDetails['address'] = $row['address'];
		
	}
	
	if(!isset($pageDetails)){
	
		return false;
		
	}
	
	return $pageDetails;

}

function generate_page($pageIdentifier, $pageQuery){
	
	if(validate_query($pageIdentifier, $pageQuery)){
	
		$pageDetails = find_page($pageIdentifier);
		
		if($pageDetails != false){
		
			require("./engine/page/" . $pageDetails['address'] . "/producer/page_producer.php");

			$producer = new pageProducer($pageDetails, $pageQuery);
			$producer->produce_page();	
			
		}
	
	}
	
}

?>