<?php

class post extends core{

	function __construct($threadID){
		
		parent::database_connect();
		$this->threadID = $threadID;
		$this->channel = parent::get_channel(false, $threadID);
		
	}
	
	function get_thread(){
	
		$result = parent::database_query("
		SELECT *
		FROM posts
		WHERE identifier = 'thread' AND id = '" . $this->threadID . "'
		");
		
		while($row = mysql_fetch_array($result)){
		
			$thread['id'] = $row['id'];
			$thread['datetime'] = date("G:i\-j\/n\/y", $row['datetime']);
			$thread['userid'] = $row['userid'];
			$thread['title'] = $row['title'];
			$thread['content'] = $row['content'];
			$thread['image'] = $row['image'];
			
		}
		
		mysql_free_result($result);
		$i = 0;
	
		$result = parent::database_query("
		SELECT *
		FROM posts
		WHERE identifier = 'post' AND title = '" . $this->threadID . "'
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
		
		$thread['channel'] = $this->channel['address'];
		$thread['post'] = $post;
		return $thread;
	
	}
	
}

?>