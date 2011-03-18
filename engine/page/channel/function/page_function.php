<?php

class channel extends core{

	function __construct($channel, $page){
		
		parent::database_connect();
		$this->pageNumber = $page;
		$this->limitLength = "10";
		$this->channel = parent::get_channel($channel, false);
		$this->eval_max_pages();
		$this->eval_limits();
		
	}
	
	function eval_max_pages(){
	
		$result = parent::database_query("
		SELECT id
		FROM posts
		WHERE channel = '" . $this->channel['id'] . "' AND identifier = 'thread'
		");
		
		$num_rows = mysql_num_rows($result);
		mysql_free_result($result);
		
		$this->maxPages = ceil($num_rows/$this->limitLength); 

	}
	
	function eval_limits(){

		if($this->pageNumber < 2){
			
			$limitStart = "0";
			
		}elseif($this->pageNumber >= $this->maxPages){
		
			$this->pageNumber = $this->maxPages;
			
			
				if($this->pageNumber == "1"){
				
					$limitStart = "0";
			
				}else{
					
					$limitStart = ($this->pageNumber - 1) * $this->limitLength;
					
				}
				
		}

		$this->selectionLimits = "LIMIT " . $limitStart . ", " . $this->limitLength;
	
	}
	
	function eval_thread_activity($thread){
	
		$result = parent::database_query("
		SELECT * 
		FROM posts
		WHERE image <> '0' AND id = '" . $thread . "'
		OR image <> '0' AND title = '" . $thread . "' AND identifier = 'post'
		");
		
		if(mysql_num_rows($result)){
		
			$countResult['images'] = mysql_num_rows($result);
			
		}else{
		
			$countResult['images'] = 0;
			
		}
		
		mysql_free_result($result);
		
		$result = parent::database_query("
		SELECT * 
		FROM posts
		WHERE title = '" . $thread . "' AND identifier = 'post'
		");
		
		if(mysql_num_rows($result)){
		
			$countResult['posts'] = mysql_num_rows($result);
			
		}else{
		
			$countResult['posts'] = 0;
			
		}
		
		return $countResult;
		
	}
	
	function get_threads(){
	
		$i = 0;
	
		$result = parent::database_query("
		SELECT *
		FROM posts
		WHERE identifier = 'thread' AND channel = '" . $this->channel['id'] . "'
		" . $this->selectionLimits
		);
		
		
		while($row = mysql_fetch_array($result)){
		
			$thread[$i]['id'] = $row['id'];
			$thread[$i]['datetime'] = date("G:i\-j\/n\/y", $row['datetime']);
			$thread[$i]['userid'] = $row['userid'];
			$thread[$i]['title'] = $row['title'];
			$thread[$i]['content'] = $row['content'];
			$thread[$i]['image'] = $row['image'];
			$thread[$i]['stats'] = $this->get_thread_stats($row['id']);
			$i++;
			
		}
	
		return $thread;
	
	}
	
	function get_posts($threadID){
	
		$i = 0;
	
		$result = parent::database_query("
		SELECT *
		FROM posts
		WHERE identifier = 'post' AND title = '" . $threadID . "' AND channel = '" . $this->channel['id'] . "'
		");
		
		
		while($row = mysql_fetch_array($result)){
			
			$post[$i]['id'] = $row['id'];
			$post[$i]['datetime'] = date("G:i\-j\/n\/y", $row['datetime']);
			$post[$i]['title'] = $row['title'];
			$post[$i]['userid'] = $row['userid'];
			$post[$i]['content'] = $row['content'];
			$post[$i]['image'] = $row['image'];
			$i++;
			
		}
		
		if(!isset($post)){
		
			$post[0]['id'] = "none";
			
		}
	
		return $post;
		
	}	
	
	function get_thread_stats($threadID){
	
		$activity['rowspan_fix'] = "2";
		$threadActivity = $this->eval_thread_activity($threadID['id']);
		
		if($threadActivity['posts'] > 1){
		
			$activity['reply'] = $threadActivity['posts'] . " replies";
			
		}elseif($threadActivity['posts'] == "1"){
		
			$activity['reply'] = "1 reply";
			
		}elseif($threadActivity['posts'] == "0"){
		
			$activity['reply']= "no replies";
			
		}
		
		if($threadActivity['images'] > 1){
		
			$activity['image'] = $threadActivity['images'] . " images";
			
		}elseif($threadActivity['images'] == "1"){
		
			$activity['image'] = "1 image";
			
		}elseif($threadActivity['images'] == "0"){
		
			$activity['image'] = "no images";
			
		}	
		
		return $activity;
		
	}
	
}

?>