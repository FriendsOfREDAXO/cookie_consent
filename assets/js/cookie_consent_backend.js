$(document).on('rex:ready', function() {
    var e = document.getElementById("cookiedingsbums_mode");
    var strUser = e.options[e.selectedIndex].value;
    if(strUser == 'opt-in') {
        $('#cookiedingsbums_allow_content').removeClass('cookie_consent_display_none');
        $('#cookiedingsbums_deny_content').addClass('cookie_consent_display_none');
        $('.cookiedingsbums_allow_content').removeClass('cookie_consent_display_none');
        $('.cookiedingsbums_deny_content').addClass('cookie_consent_display_none');
        $('.mode_optin_notice').css('display', 'block');
        $('.mode_notice').css('display', 'block');
    }
    if(strUser == 'opt-out') {
        $('#cookiedingsbums_deny_content').removeClass('cookie_consent_display_none');
        $('#cookiedingsbums_allow_content').addClass('cookie_consent_display_none');
        $('.cookiedingsbums_deny_content').removeClass('cookie_consent_display_none');
        $('.cookiedingsbums_allow_content').addClass('cookie_consent_display_none');
        $('.mode_notice').css('display', 'block');
    }
    if(strUser == 'info') {
        $('#cookiedingsbums_allow_content').addClass('cookie_consent_display_none');
        $('#cookiedingsbums_deny_content').addClass('cookie_consent_display_none');
        $('.cookiedingsbums_allow_content').addClass('cookie_consent_display_none');
        $('.cookiedingsbums_deny_content').addClass('cookie_consent_display_none');
        $('.mode_notice').css('display', 'none');
    }
    var f = document.getElementById("cookiedingsbums_select_link");
    var strUser = f.options[f.selectedIndex].value;
    if(strUser == 'eLink') {
        $('.cookiedingsbums_eLink').removeClass('cookie_consent_display_none');
        $('#cookiedingsbums_link_extern').removeClass('cookie_consent_display_none');
        $('#REX_LINK_1_NAME').parent().addClass('cookie_consent_display_none');
        $('.cookiedingsbums_iLink').addClass('cookie_consent_display_none');
        $('.cookie_dingsbums_button').addClass('cookie_consent_display_none');
    }
    if(strUser == 'iLink') {
        $('#REX_LINK_1_NAME').parent().removeClass('cookie_consent_display_none');
        $('.cookiedingsbums_iLink').removeClass('cookie_consent_display_none');
        $('.cookie_dingsbums_button').removeClass('cookie_consent_display_none');
        $('.cookiedingsbums_eLink').addClass('cookie_consent_display_none');
        $('#cookiedingsbums_link_extern').addClass('cookie_consent_display_none');
    }
    var theme = document.getElementById('cookiedingsbums_theme');
    var selTheme = theme.options[theme.selectedIndex].value;
    if(selTheme == 'clean') {
        $('#cookiedingsbums_color_background').attr('disabled', 'disabled');
        $('#cookiedingsbums_color_main_content').attr('disabled', 'disabled');
        $('#cookiedingsbums_color_button_content').attr('disabled', 'disabled');
        $('#cookiedingsbums_color_button_background').attr('disabled', 'disabled');
    } else {
        $('#cookiedingsbums_color_background').removeAttr('disabled');
        $('#cookiedingsbums_color_main_content').removeAttr('disabled');
        $('#cookiedingsbums_color_button_content').removeAttr('disabled');
        $('#cookiedingsbums_color_button_background').removeAttr('disabled');
    }
});
$(document).ready(function() {
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

    $('#cookiedingsbums_select_link').change(function() {
        var e = document.getElementById("cookiedingsbums_select_link");
        var strUser = e.options[e.selectedIndex].value;
        if(strUser == 'eLink') {
            $('#cookiedingsbums_link_extern').removeClass('cookie_consent_display_none');
            $('.cookiedingsbums_eLink').removeClass('cookie_consent_display_none');
            $('#REX_LINK_1_NAME').parent().addClass('cookie_consent_display_none');
            $('.cookiedingsbums_iLink').addClass('cookie_consent_display_none');
            $('.cookie_dingsbums_button').addClass('cookie_consent_display_none');
        }
        if(strUser == 'iLink') {
            $('#REX_LINK_1_NAME').parent().removeClass('cookie_consent_display_none');
            $('.cookiedingsbums_iLink').removeClass('cookie_consent_display_none');
            $('.cookie_dingsbums_button').removeClass('cookie_consent_display_none');
            $('.cookiedingsbums_eLink').addClass('cookie_consent_display_none');
            $('#cookiedingsbums_link_extern').addClass('cookie_consent_display_none');
        }
    });

    $('#cookiedingsbums_mode').change(function() {
        var e = document.getElementById("cookiedingsbums_mode");
        var strUser = e.options[e.selectedIndex].value;
        if(strUser == 'opt-in') {
            $('#cookiedingsbums_allow_content').removeClass('cookie_consent_display_none');
            $('#cookiedingsbums_deny_content').addClass('cookie_consent_display_none');
            $('.cookiedingsbums_allow_content').removeClass('cookie_consent_display_none');
            $('.cookiedingsbums_deny_content').addClass('cookie_consent_display_none');
            $('.mode_optin_notice').css('display', 'block');
            $('.mode_notice').css('display', 'block');
        }
        if(strUser == 'opt-out') {
            $('#cookiedingsbums_deny_content').removeClass('cookie_consent_display_none');
            $('#cookiedingsbums_allow_content').addClass('cookie_consent_display_none');
            $('.cookiedingsbums_deny_content').removeClass('cookie_consent_display_none');
            $('.cookiedingsbums_allow_content').addClass('cookie_consent_display_none');
            $('.mode_optin_notice').css('display', 'none');
            $('.mode_notice').css('display', 'block');
        }
        if(strUser == 'info') {
            $('#cookiedingsbums_allow_content').addClass('cookie_consent_display_none');
            $('#cookiedingsbums_deny_content').addClass('cookie_consent_display_none');
            $('.cookiedingsbums_allow_content').addClass('cookie_consent_display_none');
            $('.cookiedingsbums_deny_content').addClass('cookie_consent_display_none');
            $('.mode_optin_notice').css('display', 'none');
            $('.mode_notice').css('display', 'none');
        }
    });
    $('#cookiedingsbums_theme').change(function() {
        var theme = document.getElementById('cookiedingsbums_theme');
        var selTheme = theme.options[theme.selectedIndex].value;
        if(selTheme == 'clean') {
            $('#cookiedingsbums_color_background').attr('disabled', 'disabled');
            $('#cookiedingsbums_color_main_content').attr('disabled', 'disabled');
            $('#cookiedingsbums_color_button_content').attr('disabled', 'disabled');
            $('#cookiedingsbums_color_button_background').attr('disabled', 'disabled');
        } else {
            $('#cookiedingsbums_color_background').removeAttr('disabled');
            $('#cookiedingsbums_color_main_content').removeAttr('disabled');
            $('#cookiedingsbums_color_button_content').removeAttr('disabled');
            $('#cookiedingsbums_color_button_background').removeAttr('disabled');
        }
    });
    $('#cookiedingsbums_color_background').change(function() {
        $("#color_scheme option[value='0']").prop("selected","selected");
    });
    $('#cookiedingsbums_color_main_content').change(function() {
        $('#color_scheme').val('custom');
    });
    $('#cookiedingsbums_color_button_background').keyup(function() {
        $('#color_scheme').val('custom');
    });
    $('#cookiedingsbums_color_button_content').keyup(function() {
        $('#color_scheme').val('custom');
    });
});