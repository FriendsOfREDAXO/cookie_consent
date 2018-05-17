<?php

class cookie_consent { 
	public function checkUrl($url) {
		if ($url) {
			if (filter_var($url, FILTER_VALIDATE_URL) === FALSE) { 
				return false;	
			}
			return true;
		}
	}

	public function checkJson($data) {
	    if($data) {
            json_decode($data);
            return json_last_error() === JSON_ERROR_NONE;
        }
    }

	protected function cookie_consent_get_css() {
		$getFile = rex_url::base('assets/addons/cookie_consent/css/cookie_consent_insites.css');
		$makeCssLink =  '<link rel="stylesheet" href="'.$getFile.'">';
		return $makeCssLink;
	}
	protected function cookie_consent_get_js() {
		$getFile = rex_url::base('assets/addons/cookie_consent/js/cookie_consent_insites.js');
		$makeJsLink =  '<script type="text/javascript" src="'.$getFile.'"></script>';
		return $makeJsLink;
	}	

	public static function cookie_consent_backend() {
		$theme = rex_config::get('cookie_consent', 'theme');
		$color_background = rex_config::get('cookie_consent', 'color_background');
		$color_main_content = rex_config::get('cookie_consent', 'color_main_content');
		$color_button_background = rex_config::get('cookie_consent', 'color_button_background');
		$color_button_content = rex_config::get('cookie_consent', 'color_button_content');
		$position = rex_config::get('cookie_consent', 'position');
		$main_message = rex_config::get('cookie_consent', 'main_message');
		$button_content = rex_config::get('cookie_consent', 'button_content');
		$link_content = rex_config::get('cookie_consent', 'link_content');
		$link = rex_config::get('cookie_consent', 'iLink');
		$link_target_type = rex_config::get('cookie_consent', 'link_target_type');

		if($link_target_type == '') $link_target_type = '_blank';

		$interner_link = '';
		if($link != '') {
			$interner_link = rex_getUrl($link);
		}
		$externer_link = rex_config::get('cookie_consent', 'eLink');
		$mode = rex_config::get('cookie_consent', 'mode');
		$deny_content = rex_config::get('cookie_consent', 'deny_content');
		$allow_content = rex_config::get('cookie_consent', 'allow_content');
		
		$main_color_scheme = 'style="background:'.rex_escape($color_background).'; color: '.rex_escape($color_main_content).';"';
		$link_color_scheme = 'style="color: '.rex_escape($color_main_content).';"';
		$button_color_scheme = 'style="background:'.rex_escape($color_button_background).'; color:'.rex_escape($color_button_content).';"';

        $object = [
            "palette"  => [
                "popup"  => [
                    "background" => rex_escape($color_background),
                    "text"       => rex_escape($color_main_content)
                ],
                "button" => [
                    "background" => rex_escape($color_button_background),
                    "text"       => rex_escape($color_button_content)
                ]
            ],
            "theme"    => $theme,
            "position" => $position,
            "content"  => [
                "message" => rex_escape($main_message),
                "dismiss" => rex_escape($button_content),
                "deny"    => rex_escape($deny_content),
                "allow"   => rex_escape($allow_content),
                "link"    => rex_escape($link_content),
                "href"    => rex_escape($externer_link) . '' . rex_escape($interner_link)
            ],
            "type"     => $mode,
			"elements" => [
				"messagelink" =>'<span id="cookieconsent:desc" class="cc-message">{{message}} <a aria-label="learn more about cookies" tabindex="0" class="cc-link" href="{{href}}" target="'.$link_target_type.'">{{link}}</a></span>'
			]
        ];

        $custom_options = rex_config::get('cookie_consent', 'custom_options');
        $custom_options = json_decode($custom_options);
        if($custom_options) {
            $object += (array) $custom_options;
        }


        $code = '<pre><code>window.addEventListener("load", function() {
		    window.cookieconsent.initialise('.json_encode($object, JSON_PRETTY_PRINT).');
		});
		
		</code></pre>';
		
		return $code;
	}

	public static function ep_call($rex_ep) {
		$subject = $rex_ep->getSubject();

		$s = self::cookie_consent_output();

		$subject = str_replace('</head>', $s.PHP_EOL.'</head>', $subject);
		$rex_ep->setSubject($subject);
	}

	public static function cookie_consent_output() {
		$cookie = new cookie_consent();
		$cookie_consent_css = $cookie->cookie_consent_get_css();
		$cookie_consent_js = $cookie->cookie_consent_get_js();
		
		$theme = rex_config::get('cookie_consent', 'theme');
		$color_background = rex_config::get('cookie_consent', 'color_background');
		$color_main_content = rex_config::get('cookie_consent', 'color_main_content');
		$color_button_background = rex_config::get('cookie_consent', 'color_button_background');
		$color_button_content = rex_config::get('cookie_consent', 'color_button_content');
		$position = rex_config::get('cookie_consent', 'position');
		$main_message = rex_config::get('cookie_consent', 'main_message');
		$button_content = rex_config::get('cookie_consent', 'button_content');
		$link_content = rex_config::get('cookie_consent', 'link_content');
		$link = rex_config::get('cookie_consent', 'iLink');
		$link_target_type = rex_config::get('cookie_consent', 'link_target_type');

		if($link_target_type == '') $link_target_type = '_blank';

		$interner_link = '';
		if($link != '') {
			$interner_link = rex_getUrl($link);
		}
		$externer_link = rex_config::get('cookie_consent', 'eLink');
		$mode = rex_config::get('cookie_consent', 'mode');
		$deny_content = rex_config::get('cookie_consent', 'deny_content');
		$allow_content = rex_config::get('cookie_consent', 'allow_content');
		$script_checkbox = rex_config::get('cookie_consent', 'script_checkbox');
		
		if($script_checkbox != '1') {
			$cookie_consent_css = '';
			$cookie_consent_js = '';
		}
		

		$main_color_scheme = 'style="background:'.rex_escape($color_background).'; color: '.rex_escape($color_main_content).';"';
		$link_color_scheme = 'style="color: '.rex_escape($color_main_content).';"';
		$button_color_scheme = 'style="background:'.rex_escape($color_button_background).'; color:'.rex_escape($color_button_content).';"';

        $object = [
            "palette"  => [
                "popup"  => [
                    "background" => rex_escape($color_background),
                    "text"       => rex_escape($color_main_content)
                ],
                "button" => [
                    "background" => rex_escape($color_button_background),
                    "text"       => rex_escape($color_button_content)
                ]
            ],
            "theme"    => $theme,
            "position" => $position,
            "content"  => [
                "message" => rex_escape($main_message),
                "dismiss" => rex_escape($button_content),
                "deny"    => rex_escape($deny_content),
                "allow"   => rex_escape($allow_content),
                "link"    => rex_escape($link_content),
                "href"    => rex_escape($externer_link) . '' . rex_escape($interner_link)
            ],
            "type"     => $mode,
			"elements" => [
				"messagelink" =>'<span id="cookieconsent:desc" class="cc-message">{{message}} <a aria-label="learn more about cookies" tabindex="0" class="cc-link" href="{{href}}" target="'.$link_target_type.'">{{link}}</a></span>'
			]
        ];

        $custom_options = rex_config::get('cookie_consent', 'custom_options');
        $custom_options = json_decode($custom_options);
        if($custom_options) {
            $object += (array) $custom_options;
        }

        $code = $cookie_consent_css. '' . $cookie_consent_js .'<script>
            window.addEventListener("load", function() {
            window.cookieconsent.initialise('.json_encode($object, JSON_PRETTY_PRINT).');
		});
		
		</script>';
		
		return $code;
	}

}

