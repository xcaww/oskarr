<?php
	
class listingsGenerator extends database{

	function __construct($page, $channelAddress){
		
		$this->pageNumber = $page;
		$this->limitLength = "10";
		$this->channel = get_channel($channelAddress, false);
		$this->eval_max_pages();
		$this->eval_limits();
		
	}
	
	function eval_max_pages(){
	
		$result = parent::query("
		SELECT * 
		FROM posts
		");
		
		$num_rows = mysql_num_rows($result);
		mysql_free_result($result);
		
		$this->maxPages = ceil($num_rows/$this->limitLength); 
	
	}
	
	function eval_limits(){
	
		if($this->pageNumber < 1){
		
			$this->pageNumber = 1;
			
		}elseif($this->pageNumber > $this->maxPages){
		
			$this->pageNumber = $this->maxPages;
			
		}
		
		$limitStart = ($this->pageNumber - 1) * $this->limitLength;
		$this->selectionLimits = "LIMIT " . $limitStart . ", " . $this->limitLength;
	
	}
	
	function eval_thread_activity($thread){
	
		$result = parent::query("
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
		
		$result = parent::query("
		SELECT * 
		FROM posts
		WHERE title = '" . $thread . "' AND identifier = 'post'
		");
		
		if(mysql_num_rows($result)){
		
			$countResult['posts'] = mysql_num_rows($result);
			
		}else{
		
			$countResult['posts'] = 0;
			
		}
		
		mysql_free_result($result);
		return $countResult;
		
	}
	
	function get_threads($threadID){
	
		$i = 0;
		
		if(ctype_digit($threadID)){
		
			$result = parent::query("
			SELECT *
			FROM posts
			WHERE id = " . $threadID . "
			");
		
		}else{
	
			$result = parent::query("
			SELECT *
			FROM posts
			WHERE identifier = 'thread' AND channel = '" . $this->channel['id'] . "'
			" . $this->selectionLimits . "
			");
		
		}
		
		while($row = mysql_fetch_array($result)){
		
			$thread[$i]['id'] = $row['id'];
			$thread[$i]['userid'] = $row['userid'];
			$thread[$i]['title'] = $row['title'];
			$thread[$i]['content'] = $row['content'];
			$thread[$i]['image'] = $row['image'];
			$i++;
			
		}
		
		mysql_free_result($result);
		return $thread;
	
	}
	
	function get_posts($thread_id){
	
		$i = 0;
	
		$result = parent::query("
		SELECT *
		FROM posts
		WHERE title = '" . $thread_id . "' AND channel = '" . $this->channel['id'] . "'
		");
		
		while($row = mysql_fetch_array($result)){
		
			$post[$i]['id'] = $row['id'];
			$post[$i]['userid'] = $row['userid'];
			$post[$i]['title'] = $row['title'];
			$post[$i]['content'] = $row['content'];
			$post[$i]['image'] = $row['image'];
			$i++;
	
		}
		
		mysql_free_result($result);
		return $post;
	
	}
	
	function build_op($post, $single){
	
	$footerRowspan = "2";
	$threadActivity = $this->eval_thread_activity($post['id']);
	
	if($threadActivity['posts'] > 1){
	
		$replyActivity = $threadActivity['posts'] . " replies";
		
	}elseif($threadActivity['posts'] == "1"){
	
		$replyActivity = "1 reply";
		
	}elseif($threadActivity['posts'] == "0"){
	
		$replyActivity = "no replies";
		
	}
	
	if($threadActivity['images'] > 1){
	
		$imageActivity = $threadActivity['images'] . " images";
		
	}elseif($threadActivity['images'] == "1"){
	
		$imageActivity = "1 image";
		
	}elseif($threadActivity['images'] == "0"){
	
		$imageActivity = "no images";
		
	}	
	
	//first row - reply and image count
	echo "<table border=\"0\" cellspacing=\"0\"> <!-- Post Table -->
		
		";
	if($single == true){	
	echo "<tr>
			
				<td colspan=\"2\">
			
					<div id=\"post_stats_op\">
		";
	echo "				<span><a href=\"#\">view</a> - " . $replyActivity . " with " . $imageActivity . "</span>
		 ";	
	echo "			</div>
					
				</td>
			
			</tr>
		";
	}	 
	//second row - {spacer, image,} title, content
	echo "	<tr> 
			
		";
	
	if($post['image'] != "0"){
	
		$footerRowspan = "3";
		
		echo "	<td class=\"post_image_container\"> <!-- Spacer & Image -->
				
					<div id=\"post_space\">
					&nbsp;
					</div>

					<div id=\"post_image\">					
			";
			 
		echo "	<img src=\"./i/" . $this->channel['address'] . "/" . $post['image'] . "\" alt=\"" . $post['image'] . "\" />
			";
		echo "		</div>
				
				</td>
			";
			
	}else{
	
	echo "				<td>
				
					<span>&nbsp;</span>
					
				</td>
		";
		
	}
	
	echo "	<td style=\"vertical-align: top; width: 100%; background-color: #efefef;\"> <!-- Title & Post -->
					
				<div id=\"post_title_op\">
		";
	echo "				<a href=\"#\">" . $post['title'] . "</a>
		";
	echo "		</div>
		";
	echo "		<div id=\"post\">
	
					";
	echo "<p>" . $post['content'] . "</p>";
	echo "
					</div>
					
				</td>
				
			</tr>
		";
				
	//third row - footer details
	echo "			<tr>
			
				<td colspan=\"" . $footerRowspan . "\" class=\"post_footer\"> <!-- Footer -->
				
		";
	echo "<span class=\"post_details\">#" . $post['id'] . "</span>
		";
	echo "<span class=\"post_user\">Posted by Guest #" . $post['userid'] . " @ 22:55-20/2/11</span>
		";
	echo "				</td>
			
			</tr>
		";
		
	//close the table...	
	echo"	
		</table>
		";
		
	}

	
	function build_reply($post){
	
	$footerRowspan = "2";
	
	//?
	echo "<table border=\"0\" cellspacing=\"0\"> <!-- Post Table -->
		
		";
		 
	//second row - {spacer, image,} title, content
	echo "	<tr> 
			
		";
	
	if($post['image'] != "0"){
	
		$footerRowspan = "3";
		
		echo "	<td class=\"post_image_container\"> <!-- Spacer & Image -->

					<div id=\"post_image\">					
			";
			 
		echo "	<img src=\"./i/" . $this->channel['address'] . "/" . $post['image'] . "\" alt=\"" . $post['image'] . "\" />
			";
		echo "		</div>
				
				</td>
			";
			
	}else{
	
	echo "				<td>
				
				<span style=\"padding: 74px;\">&nbsp;</span>
					
				</td>
		";
		
	}
	
	echo "	<td style=\"vertical-align: top; width: 100%; background-color: #efefef;\"> <!-- Title & Post -->
					
		";
	echo "		<div id=\"post\">
	
					";
	echo "<p>" . $post['content'] . "</p>";
	echo "
					</div>
					
				</td>
				
			</tr>
		";
				
	//third row - footer details
	echo "			<tr>
			
				<td colspan=\"" . $footerRowspan . "\" class=\"post_footer\"> <!-- Footer -->
				
		";

	echo "<span class=\"post_details\">#" . $post['id'] . "</span>
		";
	echo "<span class=\"post_user\">Posted by Guest #" . $post['userid'] . " @ 22:55-20/2/11</span>
		";
	echo "				</td>
			
			</tr>
		";
		
	//close the table...	
	echo"	
		</table>
		";	
	
	}
	
}		


?>