<?php

class cookie_consent
{
    const MODE_INFO = 'info';
    const MODE_OPT_IN = 'opt-in';
    const MODE_OPT_OUT = 'opt-out';

    const COOKIE_NAME = 'cookieconsent_status';
    const COOKIE_DISMISS = 'dismiss';
    const COOKIE_ALLOW = 'allow';
    const COOKIE_DENY = 'deny';

    const LINK_EXT = 'eLink';
    const LINK_INT = 'iLink';

    const YREWRITE_VERSION_MIN = '2.3';

    private static $overridePrefix;

    public function checkUrl($url)
    {
        if ($url) {
            if (filter_var($url, FILTER_VALIDATE_URL) === false) {
                return false;
            }
            return true;
        }
    }

    public function checkJson($data)
    {
        if ($data) {
            json_decode($data);
            return json_last_error() === JSON_ERROR_NONE;
        }
    }

    public static function getCss()
    {
        $theme = self::getConfig('theme');

        if ($theme == 'clean') {
            $cssFile = 'css/cookie_consent_insites_clean.css';
        } else {
            $cssFile = 'css/cookie_consent_insites.css';
        }
        $getFile = rex_url::addonAssets('cookie_consent', $cssFile);
        $makeCssLink = '<link rel="stylesheet" href="'.$getFile.'">';
        return $makeCssLink;
    }

    public static function getJs()
    {
        $getFile = rex_url::base('assets/addons/cookie_consent/js/cookie_consent_insites.js');
        $makeJsLink = '<script type="text/javascript" src="'.$getFile.'" async></script>';
        return $makeJsLink;
    }

    public static function cookie_consent_backend()
    {
        return self::cookie_consent_output(true);
    }

    /**
     *  OUTPUT_FILTER ExtensionPoint Callback.
     *
     * @param rex_extension_point $rex_ep
     *
     * @throws rex_exception
     */
    public static function ep_call($rex_ep)
    {
        $subject = $rex_ep->getSubject();
        $output = self::cookie_consent_output();
        if ($output === '') {
            return;
        }
        $subject = str_replace('</head>', $output.PHP_EOL.'</head>', $subject);
        $rex_ep->setSubject($subject);
    }

    public static function cookie_consent_output($codepreview = false)
    {
        $inherit = self::getConfig('inherit');
        if ($inherit != '') {
            self::$overridePrefix = $inherit;
        }

        $status = self::getConfig('status');
        if ($status != '1' || (self::getGlobalConfig('hide_on_cookie') === '1' && self::getGlobalConfig('testmode') !== '1' && isset($_COOKIE[self::COOKIE_NAME]) && !$codepreview)) {
            return '';
        }

        $theme = self::getConfig('theme');
        $color_background = self::getConfig('color_background');
        $color_main_content = self::getConfig('color_main_content');
        $color_button_background = self::getConfig('color_button_background');
        $color_button_content = self::getConfig('color_button_content');
        $position = self::getConfig('position');
        $main_message = self::getConfig('main_message');
        $button_content = self::getConfig('button_content');
        $link_content = self::getConfig('link_content');
        $link = self::getConfig('iLink');
        $link_target_type = self::getConfig('link_target_type');

        $select_link = self::getConfig('select_link');

        if ($link_target_type == '') {
            $link_target_type = '_blank';
        }

        $interner_link = '';
        if ($link != '') {
            $interner_link = rex_getUrl($link);
        }
        $externer_link = self::getConfig('eLink');
        $mode = self::getConfig('mode');
        $deny_content = self::getConfig('deny_content');
        $allow_content = self::getConfig('allow_content');

        $object = [
            'theme' => $theme,
            'position' => $position,
            'content' => [
                'message' => rex_escape($main_message),
                'dismiss' => rex_escape($button_content),
                'deny' => rex_escape($deny_content),
                'allow' => rex_escape($allow_content),
                'link' => rex_escape($link_content),
                'href' => ($select_link === self::LINK_EXT ? rex_escape($externer_link) : rex_escape($interner_link)),
            ],
            'type' => $mode,
            'elements' => [
                'messagelink' => '<span id="cookieconsent:desc" class="cc-message">{{message}} <a aria-label="learn more about cookies" tabindex="0" class="cc-link" href="{{href}}" target="'.$link_target_type.'">{{link}}</a></span>',
            ],
        ];

        if (($pos = strpos($position, '-pushdown')) !== false) {
            $object['position'] = substr($position, 0, $pos);
            $object['static'] = true;
        }

        if ($theme != 'clean') {
            $object['palette'] = [
                'popup' => [
                    'background' => rex_escape($color_background),
                    'text' => rex_escape($color_main_content),
                ],
                'button' => [
                    'background' => rex_escape($color_button_background),
                    'text' => rex_escape($color_button_content),
                ],
            ];
        }
        $jsonConfig = json_encode($object, JSON_PRETTY_PRINT);

        $custom_options = self::getConfig('custom_options');
        if ($custom_options && $custom_options != '') {
            $jsonConfig = substr($jsonConfig, 0, strlen($jsonConfig) - 2) . ','.PHP_EOL.$custom_options.PHP_EOL . '}';
        }

        if (self::getGlobalConfig('testmode') === '1') {
            $jsConfigCode = 'window.cookieconsent.initialise('.$jsonConfig.', function(idx) {idx.clearStatus();idx.open();});';
        } else {
            $jsConfigCode = 'window.cookieconsent.initialise('.$jsonConfig.');';
        }

        if ($codepreview === true) {
            return $jsConfigCode;
        }

        $output = '';
        if (self::getConfig('embed_css') == '1') {
            $output .= self::getCss().PHP_EOL;
        }
        if (self::getConfig('embed_js') == '1') {
            $output .= self::getJs().PHP_EOL;
        }
        if (self::getConfig('embed_config') == '1') {
            $output .= '<script async>window.addEventListener("load", function() {'.$jsConfigCode.'});</script>';
        }

        return rex_extension::registerPoint(new rex_extension_point('COOKIE_CONTENT_OUTPUT', $output));
    }

    public static function getMode()
    {
        return rex_config::get('cookie_consent', self::getKeyPrefix().'mode', self::MODE_INFO);
    }

    public static function getStatus()
    {
        if (isset($_COOKIE[self::COOKIE_NAME])) {
            return $_COOKIE[self::COOKIE_NAME];
        }
        return null;
    }

    /**
     * Extension Point Callback
     * Removes all Cookies if the cookie-consent cookie isn't set by the user.
     *
     * @param rex_extension_point $ep
     */
    public static function ep_optin($ep)
    {
        if (!isset($_COOKIE[self::COOKIE_NAME]) || (isset($_COOKIE[self::COOKIE_NAME]) && $_COOKIE[self::COOKIE_NAME] != self::COOKIE_ALLOW)) {
            self::removeCookies();
        }
    }

    public static function removeCookies()
    {
        if (false === rex_extension::registerPoint(new rex_extension_point('COOKIE_CONSENT_COOKIE_REMOVE', true))) {
            return false;
        }

        // If user is logged in, skip
        if (session_name() != '' && rex_backend_login::hasSession()) {
            return;
        }

        // unset new/updated cookies
        header_remove('Set-Cookie');

        $headers = [];

        // mark all existing cookies as expired
        if (function_exists('getallheaders')) {
            $headers = getallheaders();
        } else {
            foreach ($_SERVER as $name => $value) {
                if (substr($name, 0, 5) == 'HTTP_') {
                    $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
                }
            }
        }

        if (array_key_exists('Cookie', $headers)) {
            // unset cookies
            $cookies = explode(';', $headers['Cookie']);
            foreach ($cookies as $cookie) {
                $parts = explode('=', $cookie);
                $name = trim($parts[0]);
                setcookie($name, '', time() - 1000);
                setcookie($name, '', time() - 1000, '/');
            }
        }
    }

    public static function getKeyPrefix()
    {
        if (self::$overridePrefix) {
            return self::$overridePrefix;
        }

        $prefix = rex_clang::getCurrent()->getCode().'_';
        if (self::checkYrewrite()) {
            if (rex_article::getCurrent()) {
                $domain = rex_yrewrite::getCurrentDomain();
            } else {
                $domain = null;
            }
            if (!$domain) {
                $domain = rex_yrewrite::getDefaultDomain();
            }
            $prefix .= $domain->getId();
        }
        $prefix .= '_';
        return $prefix;
    }

    public static function getConfig($key, $default = null)
    {
        $prefix = self::getKeyPrefix();
        return rex_config::get('cookie_consent', $prefix.$key, $default);
    }

    public static function getGlobalConfig($key, $default = null)
    {
        return rex_config::get('cookie_consent', 'global_'.$key, $default);
    }

    public static function checkYrewrite()
    {
        $yrewrite = rex_addon::get('yrewrite');
        return
            rex_addon::exists('yrewrite') &&
            rex_string::versionCompare($yrewrite->getVersion(), self::YREWRITE_VERSION_MIN, '>=') &&
            $yrewrite->isInstalled() &&
            $yrewrite->isAvailable();
    }
}
