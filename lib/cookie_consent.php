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

    protected function cookie_consent_get_css()
    {
        $theme = rex_config::get('cookie_consent', 'theme');

        if ($theme == 'clean') {
            $cssFile = 'css/cookie_consent_insites_clean.css';
        } else {
            $cssFile = 'css/cookie_consent_insites.css';
        }
        $getFile = rex_url::addonAssets('cookie_consent', $cssFile);
        $makeCssLink = '<link rel="stylesheet" href="'.$getFile.'">';
        return $makeCssLink;
    }

    protected function cookie_consent_get_js()
    {
        $getFile = rex_url::base('assets/addons/cookie_consent/js/cookie_consent_insites.js');
        $makeJsLink = '<script type="text/javascript" src="'.$getFile.'"></script>';
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
        $s = self::cookie_consent_output();

        $subject = str_replace('</head>', $s.PHP_EOL.'</head>', $subject);
        $rex_ep->setSubject($subject);
    }

    public static function cookie_consent_output($codepreview = false)
    {
        if (rex_addon::exists('yrewrite') && rex_addon::get('yrewrite')->isInstalled()) {
            rex_yrewrite::init();
        }

        $clang_prefix = self::getKeyPrefix();

        $status = rex_config::get('cookie_consent', $clang_prefix. 'status');
        if ($status != '1') {
            return '';
        }

        $theme = rex_config::get('cookie_consent', $clang_prefix.'theme');
        $color_background = rex_config::get('cookie_consent', $clang_prefix.'color_background');
        $color_main_content = rex_config::get('cookie_consent', $clang_prefix.'color_main_content');
        $color_button_background = rex_config::get('cookie_consent', $clang_prefix.'color_button_background');
        $color_button_content = rex_config::get('cookie_consent', $clang_prefix.'color_button_content');
        $position = rex_config::get('cookie_consent', $clang_prefix.'position');
        $main_message = rex_config::get('cookie_consent', $clang_prefix.'main_message');
        $button_content = rex_config::get('cookie_consent', $clang_prefix.'button_content');
        $link_content = rex_config::get('cookie_consent', $clang_prefix.'link_content');
        $link = rex_config::get('cookie_consent', $clang_prefix.'iLink');
        $link_target_type = rex_config::get('cookie_consent', $clang_prefix.'link_target_type');

        if ($link_target_type == '') {
            $link_target_type = '_blank';
        }

        $interner_link = '';
        if ($link != '') {
            $interner_link = rex_getUrl($link);
        }
        $externer_link = rex_config::get('cookie_consent', $clang_prefix.'eLink');
        $mode = rex_config::get('cookie_consent', $clang_prefix.'mode');
        $deny_content = rex_config::get('cookie_consent', $clang_prefix.'deny_content');
        $allow_content = rex_config::get('cookie_consent', $clang_prefix.'allow_content');

        $cookie = new self();
        $cookie_consent_css = $cookie->cookie_consent_get_css();
        $cookie_consent_js = $cookie->cookie_consent_get_js();

        $object = [
            'theme' => $theme,
            'position' => $position,
            'content' => [
                'message' => rex_escape($main_message),
                'dismiss' => rex_escape($button_content),
                'deny' => rex_escape($deny_content),
                'allow' => rex_escape($allow_content),
                'link' => rex_escape($link_content),
                'href' => rex_escape($externer_link) . '' . rex_escape($interner_link),
            ],
            'type' => $mode,
            'elements' => [
                'messagelink' => '<span id="cookieconsent:desc" class="cc-message">{{message}} <a aria-label="learn more about cookies" tabindex="0" class="cc-link" href="{{href}}" target="'.$link_target_type.'">{{link}}</a></span>',
            ],
        ];

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

        $custom_options = rex_config::get('cookie_consent', $clang_prefix.'custom_options');
        $custom_options = json_decode($custom_options);
        if ($custom_options) {
            $object += (array) $custom_options;
        }

        $code = ($codepreview == true ? '<pre><code>' : $cookie_consent_css. '' . $cookie_consent_js .'<script>').'
            window.addEventListener("load", function() {
            window.cookieconsent.initialise('.json_encode($object, JSON_PRETTY_PRINT).');
		});		
		'.($codepreview == true ? '</code></pre>' : '</script>');

        return $code;
    }

    public static function getMode()
    {
        return rex_config::get('cookie_consent', self::getKeyPrefix().'mode', self::MODE_INFO);
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
        $prefix = rex_clang::getCurrent()->getCode().'_';
        if (rex_addon::exists('yrewrite') && rex_addon::get('yrewrite')->isInstalled()) {
            rex_yrewrite::init();
            $domain = rex_yrewrite::getCurrentDomain();
            if (!$domain) {
                $domain = rex_yrewrite::getDefaultDomain();
            }
            $prefix .= $domain->getId();
        }
        $prefix .= '_';
        return $prefix;
    }
}
