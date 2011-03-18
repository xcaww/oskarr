<?php

class generatePage extends core{

	function __construct($pageIdentifier, $pageQuery, $pageNumber){
	
		$this->page = $pageIdentifier;
		$this->query = $pageQuery;
		
		if($pageNumber != false){
		
			$this->number = $pageNumber;
			
		}else{
		
			$this->number = false;
			
		}
		
		parent::database_connect();
		$this->validate_query();
		$this->find_page();
		$this->generate_page();

	}

	function validate_query(){

		if(ctype_alnum($this->page) == true && ctype_alnum($this->query) == true && strlen($this->page) < 33 && strlen($this->query) < 57){
		
			return true;
			
		}else{
		
			parent::send_error_log("bad page query: " . $this->page . "?" . $this->query . " -> " . $this->number);
			
		}

	}

	function find_page(){

		if(ctype_digit($this->page)){
		
			$result = parent::database_query("
			SELECT *
			FROM pages
			WHERE id = '" . $this->page . "'
			");
		
		}elseif(ctype_alnum($this->page)){
		
			$result = parent::database_query("
			SELECT *
			FROM pages
			WHERE address = '" . $this->page . "'
			");	
		
		}else{
		
			parent::send_error_log("bad page request: " . $this->page . "?" . $this->query);
			
		}

		while($row = mysql_fetch_array($result)){

			$this->pageDetails['id'] = $row['id'];
			$this->pageDetails['name'] = $row['name'];
			$this->pageDetails['address'] = $row['address'];
			
		}
		
		if(!isset($this->pageDetails)){
		
			parent::send_error_log("could not find page: " . $this->page . "?" . $this->query);
			
		}
		
		$this->pageDetails['query'] = $this->query;
		$this->pageDetails['number'] = $this->number;
		return true;

	}

	function generate_page(){
			
		require("./engine/page/page_producer.php");
		$producer = new pageProducer($this->pageDetails, $this->query);
		
	}

}

?>