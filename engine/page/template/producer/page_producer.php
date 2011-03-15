<?php

/*
	@ OSKARR (beta)
	@
	@ ||...............||	
	@    page_producer 
	@ ||...............||
	@
	@ ||...............................................................||
	@   This script utilizes the variables given from gen_page and the
	@   associated functions based in the functions directory.
	@ ||...............................................................||
	
*/

class pageProducer{

	function __construct($pageDetails, $pageQuery){
	
		$this->pageDataArray['pageName'] = $pageDetails['name'];
		$this->pageDataArray['pageID'] = $pageDetails['id'];
		$this->pageDataArray['pageAddress'] = $pageDetails['address'];
		$this->pageDataArray['pageQuery'] = $pageQuery;
		
		require_once("./engine/page/" . $this->pageDataArray['pageAddress'] . "/function/page_function.php"); //core functions; other function scripts may be called later on during this class!
		$this->construct_data();
	
	}
	
	function add_array_item($associativeKey, $associativeData){
	
		if(ctype_alpha($associativeKey)){
	
			$this->pageDataArray[$associativeKey] = $associativeData;
			
		}else{
		
			return false; //need to break this bitch... oskarr does not yet have an error handler =/
			
		}
		
	}
	
	function construct_data(){}
	//Everything to build each piece of data for the custom page is called from here.
	
	function produce_page(){
	
		require("./engine/page/" . $this->pageDataArray['pageAddress'] . "/product/" . $this->pageTemplate); //template is defined earlier during the construction of the page data
		build_page($this->pageDataArray);
	
	}

}

?>