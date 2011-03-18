<?php

class pageConstructor extends pageProducer{

	function __construct($pageDetails){
	
		require_once("./engine/page/" . $pageDetails['address'] . "/function/page_function.php");
		$this->post = new post($pageDetails['query']);
	
	}
	
	function construct_data(){
	
		$this->arrayItems['template'] = "main_index.php";
		$this->arrayItems['styles'] = "main_index.css";
		$this->arrayItems['thread'] = $this->post->get_thread();
		
		return $this->arrayItems;
		
	}

}

?>