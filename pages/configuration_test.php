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

if (rex_config::get('cookie_consent', cookie_consent::getKeyPrefix().'theme', '') == 'clean') {
    $cssFile = 'css/cookie_consent_insites_clean.css';
} else {
    $cssFile = 'css/cookie_consent_insites.css';
}
$jsFile = 'js/cookie_consent_insites.js';
$cssFileUrl = $this->getAssetsUrl($cssFile);
$jsFileUrl = $this->getAssetsUrl($jsFile);
?>
    <link rel="stylesheet" href="<?php echo $cssFileUrl; ?>">
    <script type="text/javascript" src="<?php echo $jsFileUrl; ?>"></script>
    <script>
      function showPreviewConsent() {
        document.cookie = "<?php echo cookie_consent::COOKIE_NAME; ?>=;path=/;expires=Thu, 01 Jan 1970 00:00:00 GMT";
        <?php echo cookie_consent::cookie_consent_backend(); ?>
      }
    </script>
<?php

// ----------------- FILTER SECTION

$button = [
    [
        'label' => $this->i18n('preview'),
        'icon' => 'view',
        'attributes' => [
            'class' => ['btn-lg', 'btn-primary'],
            'onclick' => 'showPreviewConsent()',
        ],
    ],
];
$fragment = new rex_fragment();
$fragment->setVar('buttons', $button, false);
$previewSection = $fragment->parse('core/buttons/button.php');

// ----------------- PREVIEW SECTION

$notice = rex_view::info($this->i18n('test_preview_notice'));
$fragment = new rex_fragment();
$fragment->setVar('title', $this->i18n('preview_section'), true);
$fragment->setVar('body', $notice.$previewSection, false);
echo $fragment->parse('core/page/section.php');

// ----------------- EMBED SECTION

$frontendPathProvider = new rex_path_default_provider($REX['HTDOCS_PATH'], $REX['BACKEND_FOLDER'], false);
$cssFileUrl = $frontendPathProvider->addonAssets($this->getName(), $cssFile);
$jsFileUrl = $frontendPathProvider->addonAssets($this->getName(), $jsFile);

$notice = rex_view::info($this->i18n('test_embed_notice'));
$notice .= '<pre><code>'.$cssFileUrl.PHP_EOL.$jsFileUrl.'</code></pre>';
$copyPasteCode = '<pre><code>'.htmlspecialchars(cookie_consent::cookie_consent_backend()).'</code></pre>';

$fragment = new rex_fragment();
$fragment->setVar('title', $this->i18n('config_code'), true);
$fragment->setVar('body', $notice.$copyPasteCode, false);
echo $fragment->parse('core/page/section.php');
