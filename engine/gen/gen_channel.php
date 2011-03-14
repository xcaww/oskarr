<?php

	require("./engine/gen/gen_listings.php");
	
	function generate_channel($pageNum, $channelName){
	
		$gen = new listingsGenerator($pageNum, $channelName);
		$threads = $gen->get_threads(null);
		
		foreach($threads as $thread){

			$gen->build_op($thread, true);
			$posts = $gen->get_posts($thread['id']);
			
			if($posts != false){
			
				foreach($posts as $post){
					
					$gen->build_reply($post);
					
				}
				
			}
			
			echo "<br style=\"height:80px;\" />";
	
		}
	
	}
	
?>