<?php

class pageConstructor extends pageProducer{

	function __construct($pageDetails){
	
		require_once("./engine/page/" . $pageDetails['address'] . "/function/page_function.php"); //core functions; other function scripts may be called later on during this class!
		$this->channels = new channels();
	
	}
	
	function construct_data(){
	
		
		$this->arrayItems['template'] = "main_index.php";
		$this->arrayItems['styles'] = "main_index.css";
		$this->arrayItems['channels'] = $this->channels->get_channels();
		$this->arrayItems['statistics'] = $this->channels->get_channel_statistics();
		$this->arrayItems['settings']['board_url'] = parent::get_settings("board_url");
		
		return $this->arrayItems;
		
	}

}

?>