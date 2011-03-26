<?php

class pageProducer extends core{

	function __construct($pageDetails){
	
	
		$this->add_array_item("pageName", $pageDetails['name']);
		$this->add_array_item("pageID", $pageDetails['id']);
		$this->add_array_item("pageAddress", $pageDetails['address']);
		$this->add_array_item("pageQuery", $pageDetails['query']);
		
		require_once("./engine/page/" . $this->pageDataArray['pageAddress'] . "/constructor/page_constructor.php");
		$this->constructor = new pageConstructor($pageDetails);
		$this->pageData = $this->constructor->construct_data();
		$this->produce_page();	
	
	}
	
	function add_array_item($associativeKey, $associativeData){
	
		if(ctype_alnum($associativeKey)){
	
			$this->pageDataArray[$associativeKey] = $associativeData;
			
		}else{
		
			send_error_log("page generation failed: invalid array key parsed -> [" . $associativeKey . "] = " . $associativeData);
			
		}
		
	}
	
	function produce_page(){
	
		while (list($key, $data) = each($this->pageData)) { 
		
			$this->add_array_item($key, $data);
			
		}

		require("./engine/page/" . $this->pageDataArray['pageAddress'] . "/product/" . $this->pageDataArray['template']);
		build_page($this->pageDataArray);
	
	}

}