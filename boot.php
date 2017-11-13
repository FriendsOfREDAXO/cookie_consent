<?php

$this->setProperty('author', 'Friends Of REDAXO');

if (rex::isBackend() && is_object(rex::getUser())) {
    rex_perm::register('cookiedingsbums[]');
}

if (rex::isBackend() && rex::getUser()) {
/* Auf Benutzerdefiniert setzen wenn anderer Wert eingefügt wird
	if($this->getConfig('cookiedingsbums_color_background') != '#64386b' && $this->getConfig('cookiedingsbums_color_background') != '#000' && $this->getConfig('cookiedingsbums_color_background') != '#343c66' && $this->getConfig('cookiedingsbums_color_background') != '#3c404d' && $this->getConfig('cookiedingsbums_color_background') != '#eaf7f7' && $this->getConfig('cookiedingsbums_color_background') != '#aa0000') {
		$this->setConfig('color_scheme', 'custom');
	}
	if($this->getConfig('cookiedingsbums_color_main_content') != '#ffcdfd' && $this->getConfig('cookiedingsbums_color_main_content') != '#EEE' && $this->getConfig('cookiedingsbums_color_main_content') != '#d6d6d6' && $this->getConfig('cookiedingsbums_color_main_content') != '#5c7291' && $this->getConfig('cookiedingsbums_color_main_content') != '#ffdddd'  && $this->getConfig('cookiedingsbums_color_main_content') != '#cfcfe8') {
		$this->setConfig('color_scheme', 'custom');
	}
	if($this->getConfig('cookiedingsbums_color_button_background') != '#f71559' && $this->getConfig('cookiedingsbums_color_button_background') != '#f8a8ff' && $this->getConfig('cookiedingsbums_color_button_background') != '#ff0000' && $this->getConfig('cookiedingsbums_color_button_background') != '#56cbdb' && $this->getConfig('cookiedingsbums_color_button_background') != '#8bed4f'  && $this->getConfig('cookiedingsbums_color_button_background') != '#f1d600') {
		$this->setConfig('color_scheme', 'custom');
	}
	if($this->getConfig('cookiedingsbums_color_button_content') != '#000' && $this->getConfig('cookiedingsbums_color_button_content') != '#cfcfe8' && $this->getConfig('cookiedingsbums_color_button_content') != '#ffffff' && $this->getConfig('cookiedingsbums_color_button_content') != '#ffdddd' && $this->getConfig('cookiedingsbums_color_button_content') != '#3f0045') {
		$this->setConfig('color_scheme', 'custom');
	}
*/	
    }
