<?php

$this->setProperty('author', 'Friends Of REDAXO');

if (rex::isBackend() && is_object(rex::getUser())) {
    rex_perm::register('cookie_consent[]');
}

if (rex::isBackend() && rex::getUser()) {
		rex_view::addCssFile($this->getAssetsUrl('css/cookie_consent_backend.css'));
		rex_view::addJsFile($this->getAssetsUrl('js/cookie_consent_backend.js'));
    }
