<?php

class post{

	function __construct($threadID){
		
		database_connect();
		$nav = call_module("pagebits", "nav", "Channels");
		echo $nav['nav'];
		$this->threadID = $threadID;
		$this->channel = get_channel(false, $threadID);
		
	}
	
	function get_thread(){
	
		$result = database_query("
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
	
		$result = database_query("
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
		
		$thread['channel'] = $this->channel;
		$thread['post'] = $post;
		return $thread;
	
	}
	
}

?>