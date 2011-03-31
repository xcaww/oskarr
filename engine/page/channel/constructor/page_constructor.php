<?php

class pageConstructor{

	function __construct($pageDetails){
	
		require_once("./engine/page/" . $pageDetails['address'] . "/function/page_function.php");
		$this->channel = new channel($pageDetails['query'], $pageDetails['number']);
	
	}
	
	function construct_data(){
	
		$this->arrayItems['template'] = "main_index.php";
		$this->arrayItems['styles'] = "main_index.css";	
		$this->arrayItems['thread'] = $this->channel->get_threads();
		$this->arrayItems['post'] = null;
		$this->arrayItems['channel'] = $this->channel->channel;
		$this->arrayItems['settings'] = get_settings();
		
		foreach($this->arrayItems['thread'] as $thread){

			$this->arrayItems['post'][$thread['id']] = $this->channel->get_posts($thread['id']);
			
		}
		
		return $this->arrayItems;
		
	}

}

?>