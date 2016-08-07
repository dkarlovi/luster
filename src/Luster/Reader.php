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
class Reader implements \Countable
{
    const FILE_UNREADABLE = 1;
    const FILE_INEXISTENT = 2;

    /** @var \SplFileObject */
    private $file;

    /** @var int */
    private $count;

    /**
     * @param string $path
     *
     * @throws \InvalidArgumentException
     */
    public function __construct($path)
    {
        if (false === file_exists($path)) {
            throw new \InvalidArgumentException(
                sprintf('Cannot access "%1$s": no such file', $path), self::FILE_INEXISTENT
            );
        } elseif (false === is_readable($path)) {
            throw new \InvalidArgumentException(
                sprintf('Cannot open "%1$s": permission denied', $path),
                self::FILE_UNREADABLE
            );
        }
        $this->file = new \SplFileObject($path, 'r');
    }

    /**
     * @param callable[] $callbacks
     *
     * @return string
     */
    public function read(array $callbacks)
    {
        /** @var string $line */
        foreach ($this->file as $line) {
            $value = trim($line);
            foreach ($callbacks as $callback) {
                $value = call_user_func($callback, $value);
            }
        }

        return $this;
    }

    /**
     * @return int
     */
    public function count()
    {
        if (null === $this->count) {
            $current = $this->file->key();
            $this->file->rewind();
            $this->file->seek(PHP_INT_MAX);
            $this->count = ($this->file->key() + 1);
            $this->file->seek($current);
        }

        return $this->count;
    }
}
