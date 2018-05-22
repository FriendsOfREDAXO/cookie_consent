<?php

$this->setProperty('author', 'Friends Of REDAXO');

if (rex::isBackend() && is_object(rex::getUser())) {
    rex_perm::register('cookie_consent[]');
}

if (rex::isBackend() && rex_be_controller::getCurrentPage() == 'cookie_consent/configuration') {
    rex_view::addCssFile($this->getAssetsUrl('css/cookie_consent_backend.css'));
    rex_view::addJsFile($this->getAssetsUrl('js/cookie_consent_backend.js'));
}

$clang_prefix = rex_clang::getCurrent()->getCode().'_';

if (!rex::isBackend() && rex_config::get('cookie_consent', $clang_prefix.'script_checkbox') == '1') {
    rex_extension::register('OUTPUT_FILTER', 'cookie_consent::ep_call', rex_extension::LATE);
}
