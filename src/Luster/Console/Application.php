<?php

/*
 * This file is part of Luster.
 *
 * Copyright (c) 2016 Dalibor Karlović
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Dkarlovi\Luster\Console;

use Dkarlovi\Luster\Command\SessionCommand;
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

    /**
     * {@inheritdoc}
     *
     * @throws \Symfony\Component\Console\Exception\LogicException
     */
    protected function getDefaultCommands()
    {
        $commands = array_merge(
            parent::getDefaultCommands(),
            [
                new SessionCommand(),
            ]
        );

        return $commands;
    }
}
