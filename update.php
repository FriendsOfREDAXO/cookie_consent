<?php
/**
 * @author bloep
 *
 * @var rex_addon $this
 */

$prefix = rex_clang::getCurrent()->getCode().'_';
$yrewrite = rex_addon::get('yrewrite');
if (rex_addon::exists('yrewrite') && $yrewrite->isInstalled() && rex_string::versionCompare($yrewrite->getVersion(), '2.3', '>=')) {
    rex_yrewrite::init();
    $domain = rex_yrewrite::getCurrentDomain();
    if (!$domain) {
        $domain = rex_yrewrite::getDefaultDomain();
    }
    $prefix .= $domain->getId();
}
$prefix .= '_';

$configs = $this->getConfig();
foreach ($configs as $key => $value) {
    if (strpos($key, $prefix) !== 0 && strpos($key, 'global_') === false) {
        // multilanguage update needed

        $this->removeConfig($key);
        if (strpos($key, 'cookiedingsbums_') === 0) {
            $key = str_replace('cookiedingsbums_', '', $key);
        }
        $this->setConfig($prefix.$key, $value);
    }
    if ($key == $prefix.'custom_options' && $value != '') {
        if (substr($value, 0, 1) === '{') {
            $value = substr($value, 1);
        }
        if (substr($value, strlen($value) - 1, 1) === '}') {
            $value = substr($value, 0, strlen($value) - 1);
        }
        $this->setConfig($key, $value);
    }
    if ($key == $prefix.'script_checkbox') {
        $this->setConfig($prefix.'embed_auto', $value);
        $this->setConfig($prefix.'embed_config', $value);
        $this->setConfig($prefix.'embed_js', $value);
        $this->setConfig($prefix.'embed_css', $value);
        $this->removeConfig($prefix.'script_checkbox');
    }
}
if (!$this->hasConfig($prefix.'status')) {
    $this->setConfig($prefix.'status', '1');
}
