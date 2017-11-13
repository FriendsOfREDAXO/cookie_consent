<?php

if (!$this->hasConfig()) {
    $this->setConfig('color_background', '');
    $this->setConfig('color_main_content', '');
    $this->setConfig('color_button_background', '');
    $this->setConfig('color_button_content', '');
    $this->setConfig('position', 'top');
    $this->setConfig('main_message', 'This website uses cookies to ensure you get the best experience on our website ');
    $this->setConfig('button_content', 'Accept');
    $this->setConfig('link_content', 'Privacy Policy');
    $this->setConfig('link', '');
    $this->setConfig('theme', 'classic');
    $this->setConfig('color_scheme', 'custom');
    $this->setConfig('mode', 'info');
    $this->setConfig('allow_content', 'Allow cookies');
    $this->setConfig('deny_content', 'Decline');
}

$somethingIsWrong = false;
if ($somethingIsWrong) {
    throw new rex_functional_exception('Something is wrong');
}
