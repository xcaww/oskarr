<?php

function build_page($pageData){

	echo "<link href=\".\engine\page\\{$pageData['pageAddress']}\product\\{$pageData['styles']}\" rel=\"stylesheet\" type=\"text/css\" />
	
	";

	foreach($pageData['thread'] as $thread){
	
		echo "		<table border=\"0\" cellspacing=\"0\"> <!-- Post Table -->
			<tr>
			
				<td colspan=\"2\">
			
					<div id=\"post_stats_op\">
					<span>{$thread['stats']['reply']} with {$thread['stats']['image']}</span>
					</div>
					
				</td>
			
			</tr>
		
			<tr> 
			
				<td class=\"post_image_container\"> <!-- Spacer & Image -->
				
					<div id=\"post_spacer\">
					
						&nbsp;
					
					</div>					
					
					<div id=\"post_image\">	
					
						<img src=\"./i/{$pageData['channelAddress']}/{$thread['image']}\" alt=\"{$thread['image']}\" />
						
					</div>
		
				</td>

				<td style=\"vertical-align: top; width: 100%; background-color: #efefef;\"> <!-- Title & Post -->

					<div id=\"post_title_op\">

							<a href=\"?post={$thread['id']}\">{$thread['title']}</a>

					</div>

					<div id=\"post\">

						<p>{$thread['content']}</p>

					</div>

				</td>

			</tr>

			<tr>

				<td colspan=\"3\" class=\"post_footer\"> <!-- Footer -->
				
					<span class=\"post_details\">{$thread['id']}</span>
					<span class=\"post_user\">Posted by <b>Guest {$thread['userid']}</b> @ <b>{$thread['datetime']}</b></span>

				</td>

			</tr>

		</table>";
		

		if($pageData['post'][$thread['id']][0]['id'] != "none"){
		
			foreach($pageData['post'][$thread['id']] as $post){
			
				if($post['image'] == "0"){
				
					$imageData = "<td>
				
					<span style=\"padding: 0;\">&nbsp;</span>

				</td>";
				
				}else{
				
					$imageData = "<td class=\"post_image_container\"> <!-- Spacer & Image -->

					<div id=\"post_image\">					

						<img src=\"./i/{$pageData['channelAddress']}/{$post['image']}\" alt=\"{$post['image']}\" />
						
					</div>

				</td>";
				
				}
				
				echo "		<table border=\"0\" cellspacing=\"0\"> <!-- Post Table -->

			<tr> 
			
				{$imageData}

				<td style=\"vertical-align: top; width: 100%; background-color: #efefef;\"> <!-- Title & Post -->

					<div id=\"post\">
				
						<p>{$post['content']}</p>

					</div>

				</td>

			</tr>

			<tr>

				<td colspan=\"2\" class=\"post_footer\"> <!-- Footer -->
				
					<span class=\"post_details\">{$post['id']}</span>
					<span class=\"post_user\">Posted by <b>Guest {$thread['userid']}</b> @ <b>{$thread['datetime']}</b></span>

				</td>

			</tr>

		</table>
		
		";
				
				
			}
		
		}
		
		echo "<br/>";
	
	}

}

?>