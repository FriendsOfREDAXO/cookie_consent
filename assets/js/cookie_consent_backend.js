$(document).ready(function() {
  $('#color_scheme').change(function() {
    var e = document.getElementById("color_scheme");
    var strUser = e.options[e.selectedIndex].value;
    if(strUser == 'girly') {
      $('#cookie_consent_color_background').val('#64386b');
      $('#cookie_consent_color_main_content').val('#ffcdfd');
      $('#cookie_consent_color_button_background').val('#f8a8ff');
      $('#cookie_consent_color_button_content').val('#3f0045');
    }
    if(strUser == 'fancyred') {
      $('#cookie_consent_color_background').val('#aa0000');
      $('#cookie_consent_color_main_content').val('#ffdddd');
      $('#cookie_consent_color_button_background').val('#ff0000');
      $('#cookie_consent_color_button_content').val('#ffdddd');
    }
    if(strUser == 'icyblue') {
      $('#cookie_consent_color_background').val('#eaf7f7');
      $('#cookie_consent_color_main_content').val('#5c7291');
      $('#cookie_consent_color_button_background').val('#56cbdb');
      $('#cookie_consent_color_button_content').val('#ffffff');
    }
    if(strUser == 'polarlights') {
      $('#cookie_consent_color_background').val('#3c404d');
      $('#cookie_consent_color_main_content').val('#d6d6d6');
      $('#cookie_consent_color_button_background').val('#8bed4f');
      $('#cookie_consent_color_button_content').val('#000');
    }
    if(strUser == 'bubblegum') {
      $('#cookie_consent_color_background').val('#343c66');
      $('#cookie_consent_color_main_content').val('#cfcfe8');
      $('#cookie_consent_color_button_background').val('#f71559');
      $('#cookie_consent_color_button_content').val('#cfcfe8');
    }
    if(strUser == 'honeybee') {
      $('#cookie_consent_color_background').val('#000');
      $('#cookie_consent_color_main_content').val('#EEE');
      $('#cookie_consent_color_button_background').val('#f1d600');
      $('#cookie_consent_color_button_content').val('#000');
    }
  });

  $('#select_link').change(function() {
    var e = document.getElementById("select_link");
    var strUser = e.options[e.selectedIndex].value;
    if(strUser == 'eLink') {
      $('.cookie_consent_eLink').parent().parent().removeClass('cookie_consent_display_none');
      $('.cookie_consent_iLink').parent().parent().addClass('cookie_consent_display_none');
    }
    if(strUser == 'iLink') {
      $('.cookie_consent_iLink').parent().parent().removeClass('cookie_consent_display_none');
      $('.cookie_consent_eLink').parent().parent().addClass('cookie_consent_display_none');
    }
  });
  $('#select_link').trigger('change');

  $('#cookie_consent_mode').change(function() {
    var e = document.getElementById("cookie_consent_mode");
    var strUser = e.options[e.selectedIndex].value;
    if(strUser == 'opt-in') {
      $('#cookie_consent_allow_content').parent().parent().removeClass('cookie_consent_display_none');
      $('#cookie_consent_deny_content').parent().parent().addClass('cookie_consent_display_none');
      $('.mode_optin_notice').css('display', 'block');
      $('.mode_notice').css('display', 'block');
    }
    if(strUser == 'opt-out') {
      $('#cookie_consent_deny_content').parent().parent().removeClass('cookie_consent_display_none');
      $('#cookie_consent_allow_content').parent().parent().addClass('cookie_consent_display_none');
      $('.mode_notice').css('display', 'block');
    }
    if(strUser == 'info') {
      $('#cookie_consent_allow_content').parent().parent().addClass('cookie_consent_display_none');
      $('#cookie_consent_deny_content').parent().parent().addClass('cookie_consent_display_none');
      $('.mode_notice').css('display', 'none');
    }
  });
  $('#cookie_consent_mode').trigger('change');
  $('#cookie_consent_theme').change(function() {
    var theme = document.getElementById('cookie_consent_theme');
    var selTheme = theme.options[theme.selectedIndex].value;

    var $colorBackground = $('#cookie_consent_color_background');
    var $colorMainContent = $('#cookie_consent_color_main_content');
    var $colorButtonContent = $('#cookie_consent_color_button_content');
    var $colorButtonBackground = $('#cookie_consent_color_button_background');
    var $design = $('#color_scheme');
    if(selTheme == 'clean') {
      $colorBackground.attr('disabled', 'disabled');
      $colorMainContent.attr('disabled', 'disabled');
      $colorButtonContent.attr('disabled', 'disabled');
      $colorButtonBackground.attr('disabled', 'disabled');

      $colorBackground.parent().parent().addClass('cookie_consent_display_none');
      $colorMainContent.parent().parent().addClass('cookie_consent_display_none');
      $colorButtonContent.parent().parent().addClass('cookie_consent_display_none');
      $colorButtonBackground.parent().parent().addClass('cookie_consent_display_none');

      $('label[for=cookie_consent_color_scheme]').parent().parent().addClass('cookie_consent_display_none');
      $design.find('option').removeAttr('selected');
      $design.find('option[value=custom]').attr('selected', true);
      $design.selectpicker('refresh');
    } else {
      $colorBackground.removeAttr('disabled');
      $colorMainContent.removeAttr('disabled');
      $colorButtonContent.removeAttr('disabled');
      $colorButtonBackground.removeAttr('disabled');

      $colorBackground.parent().parent().removeClass('cookie_consent_display_none');
      $colorMainContent.parent().parent().removeClass('cookie_consent_display_none');
      $colorButtonContent.parent().parent().removeClass('cookie_consent_display_none');
      $colorButtonBackground.parent().parent().removeClass('cookie_consent_display_none');
      $('label[for=cookie_consent_color_scheme]').parent().parent().removeClass('cookie_consent_display_none');
    }
  });
  $('#cookie_consent_theme').trigger('change');
  $('#cookie_consent_color_background,#cookie_consent_color_main_content,#cookie_consent_color_button_background,#cookie_consent_color_button_content').change(function() {
    var $design = $('#color_scheme');
    $design.find('option').removeAttr('selected');
    $design.find('option[value=custom]').attr('selected', true);
    $design.selectpicker('refresh');
  });

  var $fieldsetConfig = $('#cookie_consent_fieldset_config');

  var $inheritSel = $('#cookie_consent_inherit');
  var inheritSel = $inheritSel.get(0);
  $inheritSel.change(function() {
    if(inheritSel.options[inheritSel.selectedIndex].value === '') {
      $fieldsetConfig.show();
    } else {
      $fieldsetConfig.hide();
    }
  });
  $inheritSel.trigger('change');
});