<?php

/*
 * This file is part of Luster.
 *
 * Copyright (c) 2016 Dalibor Karlović
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

/*
 * Inspired by composer's bootstrap.php
 *
 * (c) Nils Adermann <naderman@naderman.de>
 *     Jordi Boggiano <j.boggiano@seld.be>
 */

/**
 * @param $file
 *
 * @return bool|Composer\Autoload\ClassLoader
 */
function includeIfExists($file)
{
    if (true === file_exists($file)) {
        /* @noinspection PhpIncludeInspection */
        return include $file;
    }

    return false;
}

if (false === ($loader = includeIfExists(__DIR__.'/../vendor/autoload.php'))
    && false === ($loader = includeIfExists(__DIR__.'/../../../autoload.php'))
) {
    fwrite(
        STDERR,
        'You must set up the project dependencies using `composer install`'.PHP_EOL
    );
    exit(1);
}

return $loader;
