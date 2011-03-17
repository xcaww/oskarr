<?php

class pageProducer extends core{

	function __construct($pageDetails, $pageQuery, $mappedPage){
	
	
		$this->add_array_item("pageName", $pageDetails['name']);
		$this->add_array_item("pageID", $pageDetails['id']);
		$this->add_array_item("pageAddress", $pageDetails['address']);
		$this->add_array_item("pageQuery", $pageQuery);
		
		require_once("./engine/page/" . $this->pageDataArray['pageAddress'] . "/function/page_function.php"); //core functions; other function scripts may be called later on during this class!
		$this->post = new post($this->pageDataArray['pageQuery']);
		$this->construct_data();
	
	}
	
	function add_array_item($associativeKey, $associativeData){
	
		if(ctype_alnum($associativeKey)){
	
			$this->pageDataArray[$associativeKey] = $associativeData;
			
		}else{
		
			send_error_log("page generation failed: invalid array key parsed -> [" . $associativeKey . "] = ". $associativeData);
			
		}
		
	}
	
	function construct_data(){
	
		$this->pageTemplate = "main_index.php";
		$this->add_array_item("styles", "main_index.css");	
		$this->add_array_item("thread", $this->post->get_thread());	
		
	}
	
	function produce_page(){
		
		require("./engine/page/" . $this->pageDataArray['pageAddress'] . "/product/" . $this->pageTemplate);
		build_page($this->pageDataArray);
	
	}

}

?>