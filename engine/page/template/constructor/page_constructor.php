<?php

class pageConstructor extends pageProducer{

	function __construct($pageDetails){
	
		require_once("./engine/page/" . $pageDetails['address'] . "/function/page_function.php"); //core functions; other function scripts may be called later on during this class!
		$this->template = new template(/*Pass pageDetails variable here?*/);
	
	}
	
	function construct_data(){//String data and other properties together here (from template function class), such as the page template and style
	
		$this->arrayItems['template'] = "main_index.php";
		$this->arrayItems['styles'] = "main_index.css";
		$this->arrayItems['channels'] = $this->template->do_function();
		
		return $this->arrayItems;
		
	}

}

?>