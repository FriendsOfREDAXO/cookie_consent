<?php
/**
 * @var $this rex_addon
 */
?>
<style>
	
	#cookiedingsbums_wrapper {
		height: auto;
		width: auto;
	}
	.cookiedingsbums_content {
		height: 50px;
		font-size: 1.1em;
	}
	.cookiedingsbums_text {
		display: inline-block;
		margin: 17px 10px;
	}
	.cookiedingsbums_form {
		display: inline-block;
		float: right;
		margin-right: 2%;
		margin-top: 6px;
				
	}
	.cookiedingsbums_link {
		margin-left: 15px;
	}
	.cookiedingsbums_button {
		display: inline-block;
		border-color: transparent;
		font: inherit;
		color: #FFF;
		width: auto;
		padding: 0px 25px;
		line-height: 35px;
		overflow: hidden;
		cursor: pointer;
		border-radius: 10px;
	}
	a {
		background: none;
	}

</style>




<?php
$context = new rex_context();
$context->setParam('page', rex_request('page', 'string', null));
$context->setParam('clang', rex_request('clang', 'string', null));
$context->setParam('domain', rex_request('domain', 'string', null));
if (!$context->getParam('clang')) {
    $context->setParam('clang', rex_clang::getCurrentId());
}
if ($context->getParam('domain') === null) {
    $domainId = '';
    if (cookie_consent::checkYrewrite()) {
        $allDomains = rex_yrewrite::getDomains();
        unset($allDomains['default']);
        if (count($allDomains) > 0) {
            $curDomain = reset($allDomains);
            $domainId = $curDomain->getId();
        }
    }
    $context->setParam('domain', $domainId);
}

$clangId = $context->getParam('clang');
$domainId = $context->getParam('domain');

$formElements = [];

if (cookie_consent::checkYrewrite()) {
    $button_label = '';
    $items = [];
    foreach (rex_yrewrite::getDomains() as $id => $domain) {
        $item = [];
        $item['title'] = $domain->getName();
        $item['href'] = $context->getUrl(['domain' => $domain->getId()]);
        if ($domain->getId() == $context->getParam('domain')) {
            $item['active'] = true;
            $button_label = $domain->getName();
        }
        $items[] = $item;
    }
    $fragment = new rex_fragment();
    $fragment->setVar('class', 'rex-language');
    $fragment->setVar('button_label', $button_label);
    $fragment->setVar('header', $this->i18n('select_domain'));
    $fragment->setVar('items', $items, false);

    $formElements[] = [
        'label' => '<label>'.$this->i18n('select_domain').'</label>',
        'field' => $fragment->parse('core/dropdowns/dropdown.php'),
    ];
}

if (rex_clang::count() > 1) {
    $formElements[] = [
        'label' => '<label>'.$this->i18n('select_language').'</label>',
        'field' => rex_view::clangSwitchAsDropdown($context),
    ];
}

if (count($formElements) > 0) {
    $fragment = new rex_fragment();
    $fragment->setVar('elements', $formElements, false);
    $filterContent = $fragment->parse('core/form/container.php');

    $fragment = new rex_fragment();
    $fragment->setVar('title', $this->i18n('preview_for'));
    $fragment->setVar('body', $filterContent, false);
    echo $fragment->parse('core/page/section.php');
}

$context = rex_context::restore();
if (!$context->getParam('clang')) {
    $clangId = rex_clang::getCurrentId();
} else {
    $clangId = $context->getParam('clang');
}

$clang_prefix = rex_clang::get($clangId)->getCode().'_';

if (cookie_consent::checkYrewrite()) {
    $domain = rex_yrewrite::getDomainById($domainId);
    if (!$domain) {
        $domain = rex_yrewrite::getDefaultDomain();
    }
    $clang_prefix .= $domain->getId();
    $domainName = $domain->getName();
} else {
    $domain = null;
    $domainName = '';
}
$clang_prefix .= '_';



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
$interner_link = '';
if ($link != '') {
    $interner_link = rex_getUrl($link);
}
$externer_link = rex_config::get('cookie_consent', 'eLink');
$mode = rex_config::get('cookie_consent', 'mode');
$deny_content = rex_config::get('cookie_consent', 'deny_content');
$allow_content = rex_config::get('cookie_consent', 'allow_content');

$main_color_scheme = 'style="background:'.rex_escape($color_background).'; color: '.rex_escape($color_main_content).';"';
$link_color_scheme = 'style="color: '.rex_escape($color_main_content).';"';
$button_color_scheme = 'style="background:'.rex_escape($color_button_background).'; color:'.rex_escape($color_button_content).';"';


$button = [
    [
        'label' => $this->i18n('preview'),
        'icon'  => 'view',
        'attributes' => [
            'class' => ['btn-lg', 'btn-primary']
        ]
    ]
];
$fragment = new rex_fragment();
$fragment->setVar('buttons', $button, false);
$previewSection = $fragment->parse('core/buttons/button.php');

$fragment = new rex_fragment();
$fragment->setVar('title', $this->i18n('preview_section'), true);
$fragment->setVar('body', $previewSection, false);
echo $fragment->parse('core/page/section.php');



$copyPasteCode = cookie_consent::cookie_consent_backend();

$fragment = new rex_fragment();
$fragment->setVar('title', $this->i18n('embed_code'), true);
$fragment->setVar('body', $copyPasteCode, false);
echo $fragment->parse('core/page/section.php');
