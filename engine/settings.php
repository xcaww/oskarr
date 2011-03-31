<?php

class boardSettings{

    function __construct(){

	$this->settings['board_url'] = ""; //imageboard url without the trailing slash, but always use a forawrd / slash before adding a directory name
	$this->settings['board_name'] = "OSKARR"; //imageboard's title
	$this->settings['user_browser'] = $this->get_browser();

    }

    function get_browser(){

	if (strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false) {
	    // Chrome user agent string contains both 'Chrome' and 'Safari'
	    if (strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false) {
		    return 'chrome';
	    } else {
		    return 'safari';
		}
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false) {
		return 'opera';
	} elseif (strpos($_SERVER['HTTP_USER_AGENT'], 'IE') !== false) {
		return 'iexplorer';
	} else {
		return 'default';
	}

    }

}

?>