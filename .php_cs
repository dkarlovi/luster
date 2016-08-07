<?php

$header = <<<EOF
This file is part of Luster.

Copyright (c) 2016 Dalibor Karlović

This source file is subject to the MIT license that is bundled
with this source code in the file LICENSE.
EOF;

Symfony\CS\Fixer\Contrib\HeaderCommentFixer::setHeader($header);

/** @noinspection PhpUndefinedMethodInspection */
return Symfony\CS\Config\Config::create()
    ->setUsingCache(true)
    ->fixers(
        [
            'header_comment',
            'ordered_use',
            'php_unit_construct',
            'php_unit_strict',
            'phpdoc_order',
            'strict',
            'strict_param',
            'short_array_syntax',
            '-empty_return',
        ]
    )
    ->finder(
        Symfony\CS\Finder\DefaultFinder::create()
            ->in(__DIR__)
    );
