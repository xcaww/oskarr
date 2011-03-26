<?php

class boardSettings extends core{

    function __construct(){
	
	$this->settings['board_url'] = "/osk_test"; //imageboard url without the trailing slash
	$this->settings['board_name'] = "OSKARR"; //imageboard's title

    }

}

?>
