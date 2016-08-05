<?php

$header = <<<EOF
This file is part of Luster.

Copyright (c) 2016 Dalibor Karlović

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

return Symfony\CS\Config\Config::create()
    // use default SYMFONY_LEVEL and extra fixers:
    ->fixers(
        [
            'header_comment',
            'ordered_use',
            'php_unit_construct',
            'php_unit_strict',
            'strict',
            'strict_param',
            '-empty_return',
        ]
    )
    ->finder(
        Symfony\CS\Finder\DefaultFinder::create()
            ->in(__DIR__)
    );
