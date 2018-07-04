<?php
/**
 * @author bloep
 *
 * @var rex_addon $this
 */

$context = rex_context::restore();

if ($context->getParam('save')) {
    $this->setConfig(rex_post('config', [
        ['global_testmode', 'string', '0'],
        ['global_hide_on_cookie', 'string', '0'],
    ]));
}
$formElements = [];

// Testmode
$formElements[] = [
    'label' => '<label for="testmode">'.$this->i18n('testmode').'</label>',
    'field' => '<input type="checkbox" id="testmode" name="config[global_testmode]"' . (cookie_consent::getGlobalConfig('testmode', '0') == '1' ? ' checked="checked"' : '') . ' value="1" />',
    'note' => $this->i18n('testmode_notice'),
];

// Hide JS and CSS if Cookie is set
$formElements[] = [
    'label' => '<label for="hide_on_cookie">'.$this->i18n('hide_on_cookie').'</label>',
    'field' => '<input type="checkbox" id="hide_on_cookie" name="config[global_hide_on_cookie]"' . (cookie_consent::getGlobalConfig('hide_on_cookie', '0') == '1' ? ' checked="checked"' : '') . ' value="1" />',
    'note' => $this->i18n('hide_on_cookie_notice'),
];

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$content = $fragment->parse('core/form/checkbox.php');

// Save-Button
$formElements = [];
$n = [];
$n['field'] = '<button class="btn btn-save rex-form-aligned" type="submit" name="save" value="' . $this->i18n('config_save') . '">' . $this->i18n('config_save') . '</button>';
$formElements[] = $n;

$fragment = new rex_fragment();
$fragment->setVar('elements', $formElements, false);
$buttons = $fragment->parse('core/form/submit.php');

$fragment = new rex_fragment();
$fragment->setVar('class', 'edit');
$fragment->setVar('body', $content, false);
$fragment->setVar('title', $this->i18n('global_configuration'));
$fragment->setVar('buttons', $buttons, false);
?>
<form action="<?php echo rex_url::currentBackendPage(); ?>" method="post">
    <?php echo $fragment->parse('core/page/section.php'); ?>
</form>