<?php

class cookie_consent_functions { 
	
	public function checkUrl($url) {
		if ($url) {
			if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) { 
				return false;	
			}
			return true;
		}
	}
}
?>
