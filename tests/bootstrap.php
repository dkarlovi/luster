<?php

/*
 * This file is part of Luster.
 *
 * Copyright (c) 2016 Dalibor Karlović
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

error_reporting(E_ALL);
if (function_exists('date_default_timezone_set') && function_exists('date_default_timezone_get')) {
    /* @noinspection PhpUsageOfSilenceOperatorInspection */
    date_default_timezone_set(@date_default_timezone_get());
}

require __DIR__.'/../src/bootstrap.php';
