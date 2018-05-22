<?php

$subpage = rex_be_controller::getCurrentPagePart(2);

if ($subpage === 'configuration') {
    $context = rex_context::restore();
    if (!$context->getParam('clang')) {
        $context->setParam('clang', rex_clang::getCurrentId());
    }
    echo rex_view::clangSwitchAsButtons($context);
}

echo rex_view::title('Cookie Consent');

rex_be_controller::includeCurrentPageSubPath();
