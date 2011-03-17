<?php

class generatePage extends core{

	function __construct($pageIdentifier, $pageQuery, $mappedPage = false){
	
		$this->page = $pageIdentifier;
		$this->query = $pageQuery;
		
		if($mappedPage != false){
		
			$this->mapped = $mappedPage;
			
		}else{
		
			$this->mapped = false;
			
		}
		
		parent::database_connect();
		$this->validate_query();
		$this->find_page();
		$this->generate_page();

	}

	function validate_query(){

		if(ctype_alnum($this->page) == true && ctype_alnum($this->query) == true && strlen($this->page) < 33 && strlen($this->query) < 33){
		
			return true;
			
		}else{

			parent::send_error_log("bad page query: " . $this->page . "?" . $this->query);
			
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
		
		return true;

	}

	function generate_page(){
			
		require("./engine/page/" . $this->pageDetails['address'] . "/producer/page_producer.php");

		$producer = new pageProducer($this->pageDetails, $this->query, $this->mapped);
		$producer->produce_page();	
		
	}

}

?>