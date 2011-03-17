<?php

/*
	@ OSKARR (beta)
	@
	@ page_producer 
	@
	@ This script utilizes the variables given from gen_page and the
	@ associated functions based in the functions directory.
	
*/


class pageProducer extends core{

	function __construct($pageDetails, $pageQuery){
	
	
		$this->add_array_item("pageName", $pageDetails['name']);
		$this->add_array_item("pageID", $pageDetails['id']);
		$this->add_array_item("pageAddress", $pageDetails['address']);
		$this->add_array_item("pageQuery", $pageQuery);
		
		require_once("./engine/page/" . $this->pageDataArray['pageAddress'] . "/function/page_function.php"); //core functions; other function scripts may be called later on during this class!
		$this->template = new template();
		$this->construct_data();
	
	}
	
	function add_array_item($associativeKey, $associativeData){
	
		if(ctype_alnum($associativeKey)){
	
			$this->pageDataArray[$associativeKey] = $associativeData;
			
		}else{
		
			send_error_log("page generation failed: invalid array key parsed");
			
		}
		
	}
	
	function construct_data(){ //Everything to build each piece of data for the custom page is called from here.
	
		$this->pageTemplate = "main_index.php";
		$this->add_array_item("styles", "main_index.css");
	
	}
	
	
	function produce_page(){
	
		require("./engine/page/" . $this->pageDataArray['pageAddress'] . "/product/" . $this->pageTemplate);
		build_page($this->pageDataArray);
	
	}

}

?>