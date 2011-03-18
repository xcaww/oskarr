<?php

/*
	@ OSKARR (beta)
	@
	@ main_index
	@
	@ After the producer(s) have generated the result, they are sent
	@ in an array to a template (e.g.: main_index about_index).
	@ Naming convention: PAGENAME_PAGEGROUP
	@ Using the data from the input (array), the parsed page is sent.
	
*/

function build_page($pageData){
	
	echo "<link href=\".\engine\page\\{$pageData['pageAddress']}\product\\{$pageData['styles']}\" rel=\"stylesheet\" type=\"text/css\" />
	
		<table border=\"0\" cellspacing=\"0\" cellpadding=\"0\" align=\"center\"> <!-- Post Table -->
		
			<tr> 
				
				<td style=\"text-align: center; vertical-align: top; width: 600px;\"> <!-- Title & Post -->
				
					<div id=\"channel_title\">
						<span>Channels</span>
					</div>					
					
					<div id=\"channel_list\">
						<p>";
		
	foreach($pageData['channels'] as $channel){
		
		echo "<a href=\"?channel={$channel['address']}\">/{$channel['name']}/</a>";
		
	}
	
	echo"</p>		
					</div>
					
				</td>
				
			</tr>
			
		</table>";

}

?>