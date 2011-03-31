<?php

function build_page($pageData){
    
	echo "	    <div id=\"container\">

	    <link href=\"" . dirname($_SERVER['SCRIPT_NAME']) . "/engine/page/{$pageData['pageAddress']}/product/{$pageData['styles']}\" rel=\"stylesheet\" type=\"text/css\" />

		<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\" style=\"width: 100%;\"> <!-- Post Table -->
			
			<tr>
				
				<td style=\"text-align: center; vertical-align: top;\"> <!-- Title -->
				
					<div id=\"channel_title\">
						<span>Channels</span>
					</div>
					
				</td>
				
			</tr>
			
			<tr>

				<td>
			
					<div id=\"channel_stats\">
					<span>{$pageData['statistics']['channels']} Channels</span>
					</div>
					
				</td>
				
			</tr>
				
			<tr>
				
				<td style=\"text-align: center; vertical-align: top; width: 100%;\">
	
					
					<div id=\"channel_list\">
						<p>";

	foreach($pageData['channels'] as $channel){

		echo "<a href=\"{$pageData['settings']['board_url']}/{$channel['address']}/\">/{$channel['name']}/</a>";
		
	}
	
	echo"</p>		
					</div>
					
				</td>
				
			</tr>
			
		</table>

	</div>";

}

?>