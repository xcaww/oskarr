<?php
	require("./engine/gen/gen_listings.php");

	function generate_thread($threadID){
	
		$threadChannel = get_channel(false, $threadID);
		$gen = new listingsGenerator($threadID, $threadChannel['name']);
		$thread = $gen->get_threads($threadID);
		
		$gen->build_op($thread[0], false);
		$posts = $gen->get_posts($thread[0]['id']);
		
		if($posts != false){
		
			foreach($posts as $post){
				
				$gen->build_reply($post);
				
			}
			
		}
	
	}	
	
?>