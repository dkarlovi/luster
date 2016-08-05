<?php

/*
 * This file is part of Luster.
 *
 * Copyright (c) 2016 Dalibor Karlović
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Dkarlovi\Luster;

/**
 * Class Reader.
 */
class Reader
{
    const FILE_UNREADABLE = 1;
    const FILE_UNKNOWN = 2;

    /**
     * @param string $path
     *
     * @throws \InvalidArgumentException
     *
     * @return string
     */
    public function read($path)
    {
        if (false === file_exists($path)) {
            throw new \InvalidArgumentException(
                sprintf('Cannot access "%1$s": no such file', $path), self::FILE_UNKNOWN
            );
        } elseif (false === is_readable($path)) {
            throw new \InvalidArgumentException(
                sprintf('Cannot open "%1$s": permission denied', $path),
                self::FILE_UNREADABLE
            );
        }

        return realpath($path);
    }
}
