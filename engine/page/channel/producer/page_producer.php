<?php

class pageProducer extends core{

	function __construct($pageDetails, $pageQuery, $mappedPage){
	
	
		$this->add_array_item("pageName", $pageDetails['name']);
		$this->add_array_item("pageID", $pageDetails['id']);
		$this->add_array_item("pageAddress", $pageDetails['address']);
		$this->add_array_item("channelAddress", $mappedPage);
		$this->add_array_item("pageQuery", $pageQuery);
		
		require_once("./engine/page/" . $this->pageDataArray['pageAddress'] . "/function/page_function.php"); //core functions; other function scripts may be called later on during this class!
		$this->channel = new channel($this->pageDataArray['pageQuery'], $this->pageDataArray['channelAddress']);
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
		$this->add_array_item("thread", $this->channel->get_threads());
		$this->add_array_item("post", null);
		
		foreach($this->pageDataArray['thread'] as $thread){

			$this->pageDataArray['post'][$thread['id']] = $this->channel->get_posts($thread['id']);
			
		}
		
	}
	
	function produce_page(){
	
		require("./engine/page/" . $this->pageDataArray['pageAddress'] . "/product/" . $this->pageTemplate);
		build_page($this->pageDataArray);
	
	}

}

?>