<?php
/**
 * @author bloep
 *
 * @var rex_addon $this
 */

$clang_prefix = cookie_consent::getKeyPrefix();

$configs = $this->getConfig();
foreach ($configs as $key => $value) {
    if (strpos($key, $clang_prefix) !== 0) {
        // multilanguage update needed

        $this->removeConfig($key);
        if (strpos($key, 'cookiedingsbums_') === 0) {
            $key = str_replace('cookiedingsbums_', '', $key);
        }
        $this->setConfig($clang_prefix.$key, $value);
    }
}
if (!$this->hasConfig($clang_prefix.'status')) {
    $this->setConfig($clang_prefix.'status', '1');
}
