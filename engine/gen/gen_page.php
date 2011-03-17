<?php

class generatePage extends database{

	function __construct($pageIdentifier, $pageQuery){
	
	$this->page = $pageIdentifier;
	$this->query = $pageQuery;
	
		if($this->validate_query() && $this->find_page()){
		
			$this->generate_page();
		
		}else{
		
		send_error_log("page generation failed: " . $this->page . "?" . $this->query);
		
		}

	}

	function validate_query(){

		if(ctype_alnum($this->page) == true && ctype_alnum($this->query) == true && strlen($this->page) < 33 && strlen($this->query) < 33){
		
			return true;
			
		}else{

			return false;
			
		}

	}

	function find_page(){

		if(ctype_digit($this->page)){
		
			$result = parent::query("
			SELECT *
			FROM pages
			WHERE id = '" . $this->page . "'
			");
		
		}elseif(ctype_alnum($this->page)){
		
			$result = parent::query("
			SELECT *
			FROM pages
			WHERE address = '" . $this->page . "'
			");	
		
		}else{
		
			return false;
			
		}
		
		while($row = mysql_fetch_array($result)){

			$this->pageDetails['id'] = $row['id'];
			$this->pageDetails['name'] = $row['name'];
			$this->pageDetails['address'] = $row['address'];
		}
		
		if(!isset($this->pageDetails)){
		
			return false;
			
		}
		
		return true;

	}

	function generate_page(){
			
		require("./engine/page/" . $this->pageDetails['address'] . "/producer/page_producer.php");

		$producer = new pageProducer($this->pageDetails, $this->query);
		$producer->produce_page();	
		
	}

}

?>