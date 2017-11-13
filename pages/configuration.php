<?php
$content = '';
$buttons = '';

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
        ['link', 'string'],
        ['theme', 'string'],
        ['color_scheme', 'string'],
        ['mode', 'string'],
        ['deny_content', 'string'],
        ['allow_content', 'string'],
    ]));

    echo rex_view::success($this->i18n('config_saved_cookie'));
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
$n['field'] = $select->get().'<i class="mode_notice">'.$this->i18n('mode_notice').' <a href="https://cookieconsent.insites.com/documentation/disabling-cookies/">'.$this->i18n("disable_cookies").'</a></i>';
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
$n['label'] = '<label for="cookiedingsbums_deny_content">' . $this->i18n('cookiedingsbums_deny_content') . '</label>';
$n['field'] = '<input class="form-control" type="text" id="cookiedingsbums_deny_content" name="config[deny_content]" value="' . $this->getConfig('deny_content') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');

$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_allow_content">' . $this->i18n('cookiedingsbums_allow_content') . '</label>';
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

/*$formElements = [];
$n = [];
$n['label'] = '<label for="cookiedingsbums_link">' . $this->i18n('cookiedingsbums_link') . '</label>';
$n['field'] = '<input class="form-control" type="text" id="cookiedingsbums_link" name="config[link]" value="' . $this->getConfig('link') . '"/>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content .= $fragment->parse('core/form/container.php');
*/
$formElements = [];
$artname = '';
$art = rex_article::get($this->getConfig('link'));
if ($art) {
    $artname = $art->getValue('name');
}
$n = [];
$n['label'] = '<label for="cookiedingsbums_link">' . $this->i18n('cookiedingsbums_link') . '</label>';
$n['field'] = '
<div class="rex-js-widget rex-js-widget-link">
	<div class="input-group">	
			<input class="form-control" type="text" name="REX_LINK_NAME[1]" value="'.$artname.'" id="REX_LINK_1_NAME" readonly="readonly" />
			<input type="hidden" name="config[link]" id="REX_LINK_1" value="' . $this->getConfig('link') . '" />
			<span class="input-group-btn">
				<a href="#" class="btn btn-popup" onclick="openLinkMap(\'REX_LINK_1\', \'&clang=1&category_id=1\');return false;" title="' . $this->i18n('var_link_open') . '"><i class="rex-icon rex-icon-open-linkmap"></i></a>
				<a href="#" class="btn btn-popup" onclick="deleteREXLink(1);return false;" title="' . $this->i18n('var_link_delete') . '"><i class="rex-icon rex-icon-delete-link"></i></a>
			</span>
    </div>
</div>
';
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
?>
<style>
	#cookiedingsbums_deny_content {
		visibility: hidden;
	}
	#cookiedingsbums_allow_content {
		visibility: hidden;
	}
	.mode_notice {
		display: none;
	}
</style>
<script>
$(document).on('rex:ready', function() {
	var e = document.getElementById("cookiedingsbums_mode");
	var strUser = e.options[e.selectedIndex].value;
	if(strUser == 'opt-in') {
		$('#cookiedingsbums_allow_content').css('visibility', 'visible');
		$('#cookiedingsbums_deny_content').css('visibility', 'hidden');
	}
	if(strUser == 'opt-out') {
		$('#cookiedingsbums_deny_content').css('visibility', 'visible');
		$('#cookiedingsbums_allow_content').css('visibility', 'hidden');
	}
	if(strUser == 'info') {
		$('#cookiedingsbums_allow_content').css('visibility', 'hidden');
		$('#cookiedingsbums_deny_content').css('visibility', 'hidden');
	}
})
$('#color_scheme').change(function() {
	var e = document.getElementById("color_scheme");
	var strUser = e.options[e.selectedIndex].value;
	if(strUser == 'girly') {
		$('#cookiedingsbums_color_background').val('#64386b');
		$('#cookiedingsbums_color_main_content').val('#ffcdfd');
		$('#cookiedingsbums_color_button_background').val('#f8a8ff');
		$('#cookiedingsbums_color_button_content').val('#3f0045');
	}
	if(strUser == 'fancyred') {
		$('#cookiedingsbums_color_background').val('#aa0000');
		$('#cookiedingsbums_color_main_content').val('#ffdddd');
		$('#cookiedingsbums_color_button_background').val('#ff0000');
		$('#cookiedingsbums_color_button_content').val('#ffdddd');
	}
	if(strUser == 'icyblue') {
		$('#cookiedingsbums_color_background').val('#eaf7f7');
		$('#cookiedingsbums_color_main_content').val('#5c7291');
		$('#cookiedingsbums_color_button_background').val('#56cbdb');
		$('#cookiedingsbums_color_button_content').val('#ffffff');
	}
	if(strUser == 'polarlights') {
		$('#cookiedingsbums_color_background').val('#3c404d');
		$('#cookiedingsbums_color_main_content').val('#d6d6d6');
		$('#cookiedingsbums_color_button_background').val('#8bed4f');
		$('#cookiedingsbums_color_button_content').val('#000');
	}
	if(strUser == 'bubblegum') {
		$('#cookiedingsbums_color_background').val('#343c66');
		$('#cookiedingsbums_color_main_content').val('#cfcfe8');
		$('#cookiedingsbums_color_button_background').val('#f71559');
		$('#cookiedingsbums_color_button_content').val('#cfcfe8');
	}
	if(strUser == 'honeybee') {
		$('#cookiedingsbums_color_background').val('#000');
		$('#cookiedingsbums_color_main_content').val('#EEE');
		$('#cookiedingsbums_color_button_background').val('#f1d600');
		$('#cookiedingsbums_color_button_content').val('#000');
	}
});	
$('#cookiedingsbums_mode').change(function() { 
	var e = document.getElementById("cookiedingsbums_mode");
	var strUser = e.options[e.selectedIndex].value;
	if(strUser == 'opt-in') {
		$('#cookiedingsbums_allow_content').css('visibility', 'visible');
		$('#cookiedingsbums_deny_content').css('visibility', 'hidden');
		$('.mode_notice').css('display', 'inline');
	}
	if(strUser == 'opt-out') {
		$('#cookiedingsbums_deny_content').css('visibility', 'visible');
		$('#cookiedingsbums_allow_content').css('visibility', 'hidden');
		$('.mode_notice').css('display', 'inline');
	}
	if(strUser == 'info') {
		$('#cookiedingsbums_allow_content').css('visibility', 'hidden');
		$('#cookiedingsbums_deny_content').css('visibility', 'hidden');
		$('.mode_notice').css('display', 'none');
	}
});
$('#cookiedingsbums_color_background').change(function() {
	$("#color_scheme option[value='0']").prop("selected","selected");
});
$('#cookiedingsbums_color_main_content').change(function() {
	var val = 'custom'
	$('#color_scheme').val(val);
});
$('#cookiedingsbums_color_button_background').keyup(function() {
	$('#color_scheme').val('custom');
});
$('#cookiedingsbums_color_button_content').keyup(function() {
	$('#color_scheme').val('custom');
});
</script>
