<?php

/**
 * This file is part of Luster.
 *
 * Copyright (c) 2016.
 */
namespace Dkarlovi\Luster\Console;

use Symfony\Component\Console\Application as BaseApplication;

/**
 * Class Application.
 *
 * @author Dalibor Karlović
 */
class Application extends BaseApplication
{
    /**
     * Application constructor.
     */
    public function __construct()
    {
        parent::__construct('Luster');
    }
}
