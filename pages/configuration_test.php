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

echo '<h2>Cookie Consent Test</h2>';
echo '<p>Das hier gezeigte Beispiel stellt nur deine angegebenen Werte zur Hintergrundfarbe, Button-Farbe und die jeweilige Textfarbe dar. Um die anderen Effekte zu sehen, probier einfach mal ein bisschen rum und schau es dir im Front-End an :-)</p>';
echo '</br>
		<div id="cookiedingsbums_wrapper">
			<div class="cookiedingsbums_content" '.$main_color_scheme.'>
			<p class="cookiedingsbums_text"> This website uses cookies to ensure you get the best experience on our website <a class="cookiedingsbums_link" '.$link_color_scheme.' href="'.$link.'">'.$link_content.'</a> </p> 
			<form class="cookiedingsbums_form">
			<button class="cookiedingsbums_button" '.$button_color_scheme.'>Bestätige</button>
			</form>
			</div>
	</div></br>';
echo '<p>Um den Cookie Hinweis im Frontend darzustellen, nutze bitte die Funktion: <code><pre>echo cookie_consent::cookie_consent_output();</code></pre></p>';
echo '<p>Alternative muss der folgende Code noch vor deinem schließenden head-Tag in einen script-Block gesetzt werden. Bitte nimm dir Zeit und lies dir vorher die Hilfe durch, damit auch alles reibungslos klappt</p>';
echo cookie_consent::cookie_consent_backend();
