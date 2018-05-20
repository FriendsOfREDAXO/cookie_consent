<?php
/**
 * @var rex_addon $this
 */

$content = '';
$buttons = '';
$cookie_consent = rex_addon::get('cookie_consent');
$cookie_consent_functions = new cookie_consent();
// Einstellungen speichern
if (rex_post('formsubmit', 'string') == '1') {
    $this->setConfig(rex_post('config', [
        ['color_background', 'string'],
        ['color_main_content', 'string'],
        ['color_button_background', 'string'],
        ['color_button_content', 'string'],
        ['position', 'string'],
        ['main_message', 'string'],
        ['button_content', 'string'],
        ['link_content', 'string'],
        ['iLink', 'string'],
        ['eLink', 'string'],
        ['link_target_type', 'string'],
        ['theme', 'string'],
        ['cookiedingsbums_select_link', 'string'],
        ['color_scheme', 'string'],
        ['mode', 'string'],
        ['deny_content', 'string'],
        ['allow_content', 'string'],
        ['script_checkbox', 'string'],
        ['custom_options', 'string'],
    ]));

    echo rex_view::success($this->i18n('config_saved_cookie'));
}

if ($cookie_consent_functions->checkUrl($this->getConfig('eLink')) === false) {
    $content .= rex_view::warning('Falscher Link');
    $cookie_consent->setConfig('eLink', '');
}
if ($this->getConfig('cookiedingsbums_select_link') == 'eLink') {
    $cookie_consent->setConfig('iLink', '');
}
if ($this->getConfig('cookiedingsbums_select_link') == 'iLink') {
    $cookie_consent->setConfig('eLink', '');
}
if ($cookie_consent_functions->checkJson($this->getConfig('custom_options')) === false) {
    $content .= rex_view::warning($this->i18n('json_not_valid'));
    $cookie_consent->setConfig('custom_options', '');
}

// Einfaches Textfeld

$content .= '<fieldset><legend>' . $this->i18n('config_legend') . '</legend>';

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_mode">' . $this->i18n('cookiedingsbums_mode') . '</label>';
$select = new rex_select();
$select->setId('cookiedingsbums_mode');
$select->setAttribute('class', 'form-control selectpicker');
$select->setAttribute('id', 'cookiedingsbums_mode');
$select->setName('config[mode]');
$select->addOption($this->i18n('info'), 'info');
$select->addOption($this->i18n('opt-in'), 'opt-in');
$select->addOption($this->i18n('opt-out'), 'opt-out');
$select->setSelected($this->getConfig('mode'));
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
$select->setName('config[color_scheme]');
$select->addOption($this->i18n('custom'), 'custom');
$select->addOption('Girly', 'girly');
$select->addOption('Fancyred', 'fancyred');
$select->addOption('Icyblue', 'icyblue');
$select->addOption('Polarlights', 'polarlights');
$select->addOption('Bubblegum', 'bubblegum');
$select->addOption('Honeybee', 'honeybee');
$select->setSelected($this->getConfig('color_scheme'));
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
$select->setName('config[theme]');
$select->addOption('Classic', 'classic');
$select->addOption('Edgeless', 'edgeless');
$select->addOption('Block', 'block');
$select->setSelected($this->getConfig('theme'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_color_background">' . $this->i18n('cookiedingsbums_color_background') . '</label>';
$n['field'] = '<input class="form-control minicolors" type="text" id="cookiedingsbums_color_background" name="config[color_background]" value="' . $this->getConfig('color_background') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_color_main_content">' . $this->i18n('cookiedingsbums_color_main_content') . '</label>';
$n['field'] = '<input class="form-control minicolors" type="text" id="cookiedingsbums_color_main_content" name="config[color_main_content]" value="' . $this->getConfig('color_main_content') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_main_message">' . $this->i18n('cookiedingsbums_main_message') . '</label>';
$n['field'] = '<input class="form-control" type="text" id="cookiedingsbums_main_message" name="config[main_message]" value="' . $this->getConfig('main_message') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_button_content">' . $this->i18n('cookiedingsbums_button_content') . '</label>';
$n['field'] = '<input class="form-control" type="text" id="cookiedingsbums_button_content" name="config[button_content]" value="' . $this->getConfig('button_content') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label class="cookiedingsbums_deny_content" for="cookiedingsbums_deny_content">' . $this->i18n('cookiedingsbums_deny_content') . '</label>';
$n['field'] = '<input class="form-control" type="text" id="cookiedingsbums_deny_content" name="config[deny_content]" value="' . $this->getConfig('deny_content') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label class="cookiedingsbums_allow_content" for="cookiedingsbums_allow_content">' . $this->i18n('cookiedingsbums_allow_content') . '</label>';
$n['field'] = '<input class="form-control" type="text" id="cookiedingsbums_allow_content" name="config[allow_content]" value="' . $this->getConfig('allow_content') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_color_button_content">' . $this->i18n('cookiedingsbums_color_button_content') . '</label>';
$n['field'] = '<input class="form-control minicolors" type="text" id="cookiedingsbums_color_button_content" name="config[color_button_content]" value="' . $this->getConfig('color_button_content') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_color_button_background">' . $this->i18n('cookiedingsbums_color_button_background') . '</label>';
$n['field'] = '<input class="form-control minicolors" type="text" id="cookiedingsbums_color_button_background" name="config[color_button_background]" value="' . $this->getConfig('color_button_background') . '"/>';
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
$select->setName('config[position]');
$select->addOption($this->i18n('top'), 'top');
$select->addOption($this->i18n('bottom'), 'bottom');
$select->addOption($this->i18n('bottom-left'), 'bottom-left');
$select->addOption($this->i18n('bottom-right'), 'bottom-right');
$select->setSelected($this->getConfig('position'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_link_content">' . $this->i18n('cookiedingsbums_link_content') . '</label>';
$n['field'] = '<input class="form-control" type="text" id="cookiedingsbums_link_content" name="config[link_content]" value="' . $this->getConfig('link_content') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_select_link">' . $this->i18n('cookiedingsbums_select_link') . '</label>';
$select = new rex_select();
$select->setId('cookiedingsbums_select_link');
$select->setAttribute('class', 'form-control selectpicker');
$select->setAttribute('id', 'cookiedingsbums_select_link');
$select->setName('config[cookiedingsbums_select_link]');
$select->addOption($this->i18n('eLink'), 'eLink');
$select->addOption($this->i18n('iLink'), 'iLink');
$select->setSelected($this->getConfig('cookiedingsbums_select_link'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

/* EXTERNER LINK */
$formElements = [];
$n = [];
$n['label'] = '<label class="cookiedingsbums_eLink" for="cookiedingsbums_link_extern">' . $this->i18n('cookiedingsbums_link_extern') . '</label>';
$n['field'] = '<input class="form-control" type="text" id="cookiedingsbums_link_extern" name="config[eLink]" value="' . $this->getConfig('eLink') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

/* INTERNER LINK */
$formElements = [];
$artname = '';
$art = rex_article::get($this->getConfig('iLink'));
if ($art) {
    $artname = $art->getValue('name');
}
$n = [];
$n['label'] = '<label class="cookiedingsbums_iLink" for="cookiedingsbums_link">' . $this->i18n('cookiedingsbums_link_intern') . '</label>';
$n['field'] = '
<div class="rex-js-widget rex-js-widget-link">
	<div class="input-group">	
			<input class="form-control" type="text" name="REX_LINK_NAME[1]" value="'.$artname.'" id="REX_LINK_1_NAME" readonly="readonly" />
			<input type="hidden" name="config[iLink]" id="REX_LINK_1" value="' . $this->getConfig('iLink') . '" />
			<span class="input-group-btn">
				<a href="#" class="btn btn-popup cookie_dingsbums_button" onclick="openLinkMap(\'REX_LINK_1\', \'&clang=1&category_id=1\');return false;" title="' . $this->i18n('var_link_open') . '"><i class="rex-icon rex-icon-open-linkmap"></i></a>
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
$select->setName('config[link_target_type]');
$select->addOption($this->i18n('targetSelf'), '_self');
$select->addOption($this->i18n('targetBlank'), '_blank');
$select->addOption($this->i18n('targetParent'), '_parent');
$select->addOption($this->i18n('targetTop'), '_top');
$select->setSelected($this->getConfig('link_target_type'));
$n['field'] = $select->get();
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

/* CSS UND JS AUTOMATISCH EINBINDEN */

$formElements = [];
$n = [];
$n['label'] = '<label for="script-checkbox">' . $this->i18n('script-checkbox') . '</label>';
$n['field'] = '<input type="checkbox" id="script-checkbox" name="config[script_checkbox]"' . (!empty($this->getConfig('script_checkbox')) && $this->getConfig('script_checkbox') == '1' ? ' checked="checked"' : '') . ' value="1" />';
$n['note'] = '<small>'.$this->i18n('script-checkbox-notice').'</small>';
$formElements[] = $n;
$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/checkbox.php');

/* Custom Options */
$formElements = [];
$n = [];
$n['label'] = '<label for="custom-options">' . $this->i18n('custom_options') . '</label>';
$n['field'] = '<textarea class="form-control" id="custom-options" name="config[custom_options]">' . $this->getConfig('custom_options') . '</textarea><i class="custom_options_notice">'.$this->i18n('custom_options_notice').' <a href="https://cookieconsent.insites.com/documentation/javascript-api/" target="_blank">JavaScript API</a></i>';
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
$fragment->setVar('title', $this->i18n('config'));
$fragment->setVar('body', $content, false);
$fragment->setVar('buttons', $buttons, false);
$output = $fragment->parse('core/page/section.php');

$output = '
<form action="' . rex_url::currentBackendPage() . '" method="post">
<input type="hidden" name="formsubmit" value="1" />
    ' . $output . '
</form>
';

echo $output;
