<?php

echo rex_view::title('Cookie Consent');

$subpage = rex_be_controller::getCurrentPagePart(2);

rex_be_controller::includeCurrentPageSubPath();
