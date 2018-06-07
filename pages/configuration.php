<?php
/**
 * @var rex_addon $this
 */

$context = new rex_context();
$context->setParam('page', rex_request('page', 'string', null));
$context->setParam('clang', rex_request('clang', 'string', null));
$context->setParam('domain', rex_request('domain', 'string', null));
if (!$context->getParam('clang')) {
    $context->setParam('clang', rex_clang::getCurrentId());
}
if (!$context->getParam('domain')) {
    $domainId = '';
    $context->setParam('domain', $domainId);
}

$clangId = $context->getParam('clang');
$domainId = $context->getParam('domain');

if (cookie_consent::checkYrewrite()) {
    $formElements = [];

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

$n = [
    'label' => '<label>'.$this->i18n('select_language').'</label>',
    'field' => rex_view::clangSwitchAsDropdown($context),
];

$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$filterContent = $fragment->parse('core/form/container.php');

$fragment = new rex_fragment();
$fragment->setVar('title', $this->i18n('settings_for'));
$fragment->setVar('body', $filterContent, false);
echo $fragment->parse('core/page/section.php');

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
$domainEnabled = $domain != null;

$content = '';
$buttons = '';
$cookie_consent = rex_addon::get('cookie_consent');
$cookie_consent_functions = new cookie_consent();
// Einstellungen speichern
if (rex_post('formsubmit', 'string') == '1') {
    $this->setConfig(rex_post('config', [
        [$clang_prefix.'color_background', 'string'],
        [$clang_prefix.'color_main_content', 'string'],
        [$clang_prefix.'color_button_background', 'string'],
        [$clang_prefix.'color_button_content', 'string'],
        [$clang_prefix.'position', 'string'],
        [$clang_prefix.'main_message', 'string'],
        [$clang_prefix.'button_content', 'string'],
        [$clang_prefix.'link_content', 'string'],
        [$clang_prefix.'iLink', 'string'],
        [$clang_prefix.'eLink', 'string'],
        [$clang_prefix.'link_target_type', 'string'],
        [$clang_prefix.'theme', 'string'],
        [$clang_prefix.'select_link', 'string'],
        [$clang_prefix.'color_scheme', 'string'],
        [$clang_prefix.'mode', 'string'],
        [$clang_prefix.'deny_content', 'string'],
        [$clang_prefix.'allow_content', 'string'],
        [$clang_prefix.'script_checkbox', 'string'],
        [$clang_prefix.'custom_options', 'string'],
        [$clang_prefix.'status', 'string'],
    ]));

    echo rex_view::success($this->i18n('config_saved_cookie'));
}

if ($cookie_consent_functions->checkUrl($this->getConfig($clang_prefix.'eLink')) === false) {
    $content .= rex_view::warning('Falscher Link');
    $cookie_consent->setConfig($clang_prefix.'eLink', '');
}
if ($this->getConfig('cookiedingsbums_select_link') == 'eLink') {
    $cookie_consent->setConfig($clang_prefix.'iLink', '');
}
if ($this->getConfig('cookiedingsbums_select_link') == 'iLink') {
    $cookie_consent->setConfig($clang_prefix.'eLink', '');
}
if ($cookie_consent_functions->checkJson($this->getConfig($clang_prefix.'custom_options')) === false) {
    $content .= rex_view::warning($this->i18n('json_not_valid'));
    $cookie_consent->setConfig($clang_prefix.'custom_options', '');
}

$content .= '<fieldset><legend>'.$this->i18n('status').'</legend>';

$formElements = [];
$n = [];
$n['label'] = '<label for="cookie_consent_status">'.$this->i18n('activate_for_lang'.($domainEnabled ? '_domain' : ''), rex_clang::get($clangId)->getCode(), $domainName).'</label>';
$n['field'] = '<input type="checkbox" id="cookie_consent_status" name="config['.$clang_prefix.'status]"' . (!empty($this->getConfig($clang_prefix.'status')) && $this->getConfig($clang_prefix.'status') == '1' ? ' checked="checked"' : '') . ' value="1" />';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/checkbox.php');

$content .= '</fieldset><fieldset><legend>' . $this->i18n('config_legend') . '</legend>';

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_mode">' . $this->i18n('cookiedingsbums_mode') . '</label>';
$select = new rex_select();
$select->setId('cookiedingsbums_mode');
$select->setAttribute('class', 'form-control selectpicker');
$select->setAttribute('id', 'cookiedingsbums_mode');
$select->setName('config['.$clang_prefix.'mode]');
$select->addOption($this->i18n('info'), 'info');
$select->addOption($this->i18n('opt-in'), 'opt-in');
$select->addOption($this->i18n('opt-out'), 'opt-out');
$select->setSelected($this->getConfig($clang_prefix.'mode'));
$n['field'] = $select->get().'<i class="mode_optin_notice">'.$this->i18n('mode_optin_notice').'</i>';
$n['field'] .= '<i class="mode_notice">'.$this->i18n('mode_notice').' <a href="https://cookieconsent.insites.com/documentation/disabling-cookies/">'.$this->i18n('disable_cookies').'</a></i>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_color_scheme">' . $this->i18n('cookiedingsbums_color_scheme') . '</label>';
$select = new rex_select();
$select->setId('cookiedingsbums_color_scheme');
$select->setAttribute('class', 'form-control selectpicker');
$select->setAttribute('id', 'color_scheme');
$select->setName('config['.$clang_prefix.'color_scheme]');
$select->addOption($this->i18n('custom'), 'custom');
$select->addOption('Girly', 'girly');
$select->addOption('Fancyred', 'fancyred');
$select->addOption('Icyblue', 'icyblue');
$select->addOption('Polarlights', 'polarlights');
$select->addOption('Bubblegum', 'bubblegum');
$select->addOption('Honeybee', 'honeybee');
$select->setSelected($this->getConfig($clang_prefix.'color_scheme'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_theme">' . $this->i18n('cookiedingsbums_theme') . '</label>';
$select = new rex_select();
$select->setId('cookiedingsbums_theme');
$select->setAttribute('class', 'form-control selectpicker');
$select->setName('config['.$clang_prefix.'theme]');
$select->addOption('Clean', 'clean');
$select->addOption('Classic', 'classic');
$select->addOption('Edgeless', 'edgeless');
$select->addOption('Block', 'block');
$select->setSelected($this->getConfig($clang_prefix.'theme'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_color_background">' . $this->i18n('cookiedingsbums_color_background') . '</label>';
$n['field'] = '<input class="form-control minicolors" type="text" id="cookiedingsbums_color_background" name="config['.$clang_prefix.'color_background]" value="' . $this->getConfig($clang_prefix.'color_background') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_color_main_content">' . $this->i18n('cookiedingsbums_color_main_content') . '</label>';
$n['field'] = '<input class="form-control minicolors" type="text" id="cookiedingsbums_color_main_content" name="config['.$clang_prefix.'color_main_content]" value="' . $this->getConfig($clang_prefix.'color_main_content') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_main_message">' . $this->i18n('cookiedingsbums_main_message') . '</label>';
$n['field'] = '<input class="form-control" type="text" id="cookiedingsbums_main_message" name="config['.$clang_prefix.'main_message]" value="' . $this->getConfig($clang_prefix.'main_message') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_button_content">' . $this->i18n('cookiedingsbums_button_content') . '</label>';
$n['field'] = '<input class="form-control" type="text" id="cookiedingsbums_button_content" name="config['.$clang_prefix.'button_content]" value="' . $this->getConfig($clang_prefix.'button_content') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label class="cookiedingsbums_deny_content" for="cookiedingsbums_deny_content">' . $this->i18n('cookiedingsbums_deny_content') . '</label>';
$n['field'] = '<input class="form-control" type="text" id="cookiedingsbums_deny_content" name="config['.$clang_prefix.'deny_content]" value="' . $this->getConfig($clang_prefix.'deny_content') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label class="cookiedingsbums_allow_content" for="cookiedingsbums_allow_content">' . $this->i18n('cookiedingsbums_allow_content') . '</label>';
$n['field'] = '<input class="form-control" type="text" id="cookiedingsbums_allow_content" name="config['.$clang_prefix.'allow_content]" value="' . $this->getConfig($clang_prefix.'allow_content') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_color_button_content">' . $this->i18n('cookiedingsbums_color_button_content') . '</label>';
$n['field'] = '<input class="form-control minicolors" type="text" id="cookiedingsbums_color_button_content" name="config['.$clang_prefix.'color_button_content]" value="' . $this->getConfig($clang_prefix.'color_button_content') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_color_button_background">' . $this->i18n('cookiedingsbums_color_button_background') . '</label>';
$n['field'] = '<input class="form-control minicolors" type="text" id="cookiedingsbums_color_button_background" name="config['.$clang_prefix.'color_button_background]" value="' . $this->getConfig($clang_prefix.'color_button_background') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_position">' . $this->i18n('cookiedingsbums_position') . '</label>';
$select = new rex_select();
$select->setId('cookiedingsbums_position');
$select->setAttribute('class', 'form-control selectpicker');
$select->setName('config['.$clang_prefix.'position]');
$select->addOption($this->i18n('top'), 'top');
$select->addOption($this->i18n('bottom'), 'bottom');
$select->addOption($this->i18n('bottom-left'), 'bottom-left');
$select->addOption($this->i18n('bottom-right'), 'bottom-right');
$select->setSelected($this->getConfig($clang_prefix.'position'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_link_content">' . $this->i18n('cookiedingsbums_link_content') . '</label>';
$n['field'] = '<input class="form-control" type="text" id="cookiedingsbums_link_content" name="config['.$clang_prefix.'link_content]" value="' . $this->getConfig($clang_prefix.'link_content') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_select_link">' . $this->i18n('cookiedingsbums_select_link') . '</label>';
$select = new rex_select();
$select->setId('select_link');
$select->setAttribute('class', 'form-control selectpicker');
$select->setAttribute('id', 'select_link');
$select->setName('config['.$clang_prefix.'select_link]');
$select->addOption($this->i18n('eLink'), 'eLink');
$select->addOption($this->i18n('iLink'), 'iLink');
$select->setSelected($this->getConfig($clang_prefix.'select_link'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

/* EXTERNER LINK */
$formElements = [];
$n = [];
$n['label'] = '<label class="cookiedingsbums_eLink" for="cookiedingsbums_link_extern">' . $this->i18n('cookiedingsbums_link_extern') . '</label>';
$n['field'] = '<input class="form-control" type="text" id="cookiedingsbums_link_extern" name="config['.$clang_prefix.'eLink]" value="' . $this->getConfig($clang_prefix.'eLink') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

/* INTERNER LINK */
$formElements = [];
$artname = '';
$art = rex_article::get($this->getConfig($clang_prefix.'iLink'));
if ($art) {
    $artname = $art->getValue('name');
}
$n = [];
$n['label'] = '<label class="cookiedingsbums_iLink" for="cookiedingsbums_link">' . $this->i18n('cookiedingsbums_link_intern') . '</label>';
$n['field'] = '
<div class="rex-js-widget rex-js-widget-link">
	<div class="input-group">	
			<input class="form-control" type="text" name="REX_LINK_NAME[1]" value="'.$artname.'" id="REX_LINK_1_NAME" readonly="readonly" />
			<input type="hidden" name="config['.$clang_prefix.'iLink]" id="REX_LINK_1" value="' . $this->getConfig($clang_prefix.'iLink') . '" />
			<span class="input-group-btn">
				<a href="#" class="btn btn-popup cookie_dingsbums_button" onclick="openLinkMap(\'REX_LINK_1\', \'\');return false;" title="' . $this->i18n('var_link_open') . '"><i class="rex-icon rex-icon-open-linkmap"></i></a>
				<a href="#" class="btn btn-popup cookie_dingsbums_button" onclick="deleteREXLink(1);return false;" title="' . $this->i18n('var_link_delete') . '"><i class="rex-icon rex-icon-delete-link"></i></a>
			</span>
    </div>
</div>
';
$formElements[] = $n;
$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

/* LINK-TARGET-TYPE */
$formElements = [];
$n = [];
$n['label'] = '<label for="link_target_type">' . $this->i18n('link_target_type') . '</label>';
$select = new rex_select();
$select->setId('link_target_type');
$select->setAttribute('class', 'form-control selectpicker');
$select->setAttribute('id', 'link_target_type');
$select->setName('config['.$clang_prefix.'link_target_type]');
$select->addOption($this->i18n('targetSelf'), '_self');
$select->addOption($this->i18n('targetBlank'), '_blank');
$select->addOption($this->i18n('targetParent'), '_parent');
$select->addOption($this->i18n('targetTop'), '_top');
$select->setSelected($this->getConfig($clang_prefix.'link_target_type'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

/* CSS UND JS AUTOMATISCH EINBINDEN */

$formElements = [];
$n = [];
$n['label'] = '<label for="script-checkbox">' . $this->i18n('script-checkbox') . '</label>';
$n['field'] = '<input type="checkbox" id="script-checkbox" name="config['.$clang_prefix.'script_checkbox]"' . (!empty($this->getConfig($clang_prefix.'script_checkbox')) && $this->getConfig($clang_prefix.'script_checkbox') == '1' ? ' checked="checked"' : '') . ' value="1" />';
$n['note'] = '<small>'.$this->i18n('script-checkbox-notice').'</small>';
$formElements[] = $n;
$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/checkbox.php');

/* Custom Options */
$formElements = [];
$n = [];
$n['label'] = '<label for="custom-options">' . $this->i18n('custom_options') . '</label>';
$n['field'] = '<textarea class="form-control" id="custom-options" name="config['.$clang_prefix.'custom_options]">' . $this->getConfig($clang_prefix.'custom_options') . '</textarea><i class="custom_options_notice">'.$this->i18n('custom_options_notice').' <a href="https://cookieconsent.insites.com/documentation/javascript-api/" target="_blank">JavaScript API</a></i>';
$formElements[] = $n;
$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

// Save-Button
$formElements = [];
$n = [];
$n['field'] = '<button class="btn btn-save rex-form-aligned" type="submit" name="save" value="' . $this->i18n('config_save') . '">' . $this->i18n('config_save') . '</button>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$buttons = $fragment->parse('core/form/submit.php');
$buttons = '
<fieldset class="rex-form-action">
    ' . $buttons . '
</fieldset>
';

// Ausgabe Formular
$fragment = new rex_fragment();
$fragment->setVar('class', 'edit');
$fragment->setVar('title', $this->i18n('config_lang'.($domainEnabled ? '_domain' : ''), rex_clang::get($clangId)->getName(), $domainName), false);
$fragment->setVar('body', $content, false);
$fragment->setVar('buttons', $buttons, false);
$output = $fragment->parse('core/page/section.php');

$output = '
<form action="' . rex_url::currentBackendPage() . '" method="post">
<input type="hidden" name="clang" value="'.$clangId.'">
<input type="hidden" name="domain" value="'.$domainId.'">
<input type="hidden" name="formsubmit" value="1" />
    ' . $output . '
</form>
';

echo $output;
