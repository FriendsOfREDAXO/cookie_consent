$(document).on('rex:ready', function() {
    var e = document.getElementById("cookie_consent_mode");
    var strUser = e.options[e.selectedIndex].value;
    if(strUser == 'opt-in') {
        $('#cookie_consent_allow_content').removeClass('cookie_consent_display_none');
        $('#cookie_consent_deny_content').addClass('cookie_consent_display_none');
        $('.cookie_consent_allow_content').removeClass('cookie_consent_display_none');
        $('.cookie_consent_deny_content').addClass('cookie_consent_display_none');
        $('.mode_optin_notice').css('display', 'block');
        $('.mode_notice').css('display', 'block');
    }
    if(strUser == 'opt-out') {
        $('#cookie_consent_deny_content').removeClass('cookie_consent_display_none');
        $('#cookie_consent_allow_content').addClass('cookie_consent_display_none');
        $('.cookie_consent_deny_content').removeClass('cookie_consent_display_none');
        $('.cookie_consent_allow_content').addClass('cookie_consent_display_none');
        $('.mode_notice').css('display', 'block');
    }
    if(strUser == 'info') {
        $('#cookie_consent_allow_content').addClass('cookie_consent_display_none');
        $('#cookie_consent_deny_content').addClass('cookie_consent_display_none');
        $('.cookie_consent_allow_content').addClass('cookie_consent_display_none');
        $('.cookie_consent_deny_content').addClass('cookie_consent_display_none');
        $('.mode_notice').css('display', 'none');
    }
    var f = document.getElementById("select_link");
    var strUser = f.options[f.selectedIndex].value;
    if(strUser == 'eLink') {
        $('.cookie_consent_eLink').removeClass('cookie_consent_display_none');
        $('#cookie_consent_link_extern').removeClass('cookie_consent_display_none');
        $('#REX_LINK_1_NAME').parent().addClass('cookie_consent_display_none');
        $('.cookie_consent_iLink').addClass('cookie_consent_display_none');
        $('.cookie_dingsbums_button').addClass('cookie_consent_display_none');
    }
    if(strUser == 'iLink') {
        $('#REX_LINK_1_NAME').parent().removeClass('cookie_consent_display_none');
        $('.cookie_consent_iLink').removeClass('cookie_consent_display_none');
        $('.cookie_dingsbums_button').removeClass('cookie_consent_display_none');
        $('.cookie_consent_eLink').addClass('cookie_consent_display_none');
        $('#cookie_consent_link_extern').addClass('cookie_consent_display_none');
    }
    var theme = document.getElementById('cookie_consent_theme');
    var selTheme = theme.options[theme.selectedIndex].value;
    if(selTheme == 'clean') {
        $('#cookie_consent_color_background').attr('disabled', 'disabled');
        $('#cookie_consent_color_main_content').attr('disabled', 'disabled');
        $('#cookie_consent_color_button_content').attr('disabled', 'disabled');
        $('#cookie_consent_color_button_background').attr('disabled', 'disabled');
    } else {
        $('#cookie_consent_color_background').removeAttr('disabled');
        $('#cookie_consent_color_main_content').removeAttr('disabled');
        $('#cookie_consent_color_button_content').removeAttr('disabled');
        $('#cookie_consent_color_button_background').removeAttr('disabled');
    }
});
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
            $('#cookie_consent_link_extern').removeClass('cookie_consent_display_none');
            $('.cookie_consent_eLink').removeClass('cookie_consent_display_none');
            $('#REX_LINK_1_NAME').parent().addClass('cookie_consent_display_none');
            $('.cookie_consent_iLink').addClass('cookie_consent_display_none');
            $('.cookie_dingsbums_button').addClass('cookie_consent_display_none');
        }
        if(strUser == 'iLink') {
            $('#REX_LINK_1_NAME').parent().removeClass('cookie_consent_display_none');
            $('.cookie_consent_iLink').removeClass('cookie_consent_display_none');
            $('.cookie_dingsbums_button').removeClass('cookie_consent_display_none');
            $('.cookie_consent_eLink').addClass('cookie_consent_display_none');
            $('#cookie_consent_link_extern').addClass('cookie_consent_display_none');
        }
    });

    $('#cookie_consent_mode').change(function() {
        var e = document.getElementById("cookie_consent_mode");
        var strUser = e.options[e.selectedIndex].value;
        if(strUser == 'opt-in') {
            $('#cookie_consent_allow_content').removeClass('cookie_consent_display_none');
            $('#cookie_consent_deny_content').addClass('cookie_consent_display_none');
            $('.cookie_consent_allow_content').removeClass('cookie_consent_display_none');
            $('.cookie_consent_deny_content').addClass('cookie_consent_display_none');
            $('.mode_optin_notice').css('display', 'block');
            $('.mode_notice').css('display', 'block');
        }
        if(strUser == 'opt-out') {
            $('#cookie_consent_deny_content').removeClass('cookie_consent_display_none');
            $('#cookie_consent_allow_content').addClass('cookie_consent_display_none');
            $('.cookie_consent_deny_content').removeClass('cookie_consent_display_none');
            $('.cookie_consent_allow_content').addClass('cookie_consent_display_none');
            $('.mode_optin_notice').css('display', 'none');
            $('.mode_notice').css('display', 'block');
        }
        if(strUser == 'info') {
            $('#cookie_consent_allow_content').addClass('cookie_consent_display_none');
            $('#cookie_consent_deny_content').addClass('cookie_consent_display_none');
            $('.cookie_consent_allow_content').addClass('cookie_consent_display_none');
            $('.cookie_consent_deny_content').addClass('cookie_consent_display_none');
            $('.mode_optin_notice').css('display', 'none');
            $('.mode_notice').css('display', 'none');
        }
    });
    $('#cookie_consent_theme').change(function() {
        var theme = document.getElementById('cookie_consent_theme');
        var selTheme = theme.options[theme.selectedIndex].value;
        if(selTheme == 'clean') {
            $('#cookie_consent_color_background').attr('disabled', 'disabled');
            $('#cookie_consent_color_main_content').attr('disabled', 'disabled');
            $('#cookie_consent_color_button_content').attr('disabled', 'disabled');
            $('#cookie_consent_color_button_background').attr('disabled', 'disabled');
        } else {
            $('#cookie_consent_color_background').removeAttr('disabled');
            $('#cookie_consent_color_main_content').removeAttr('disabled');
            $('#cookie_consent_color_button_content').removeAttr('disabled');
            $('#cookie_consent_color_button_background').removeAttr('disabled');
        }
    });
    $('#cookie_consent_color_background').change(function() {
        $("#color_scheme option[value='0']").prop("selected","selected");
    });
    $('#cookie_consent_color_main_content').change(function() {
        $('#color_scheme').val('custom');
    });
    $('#cookie_consent_color_button_background').keyup(function() {
        $('#color_scheme').val('custom');
    });
    $('#cookie_consent_color_button_content').keyup(function() {
        $('#color_scheme').val('custom');
    });
});