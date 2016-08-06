<?php

/*
 * This file is part of Luster.
 *
 * Copyright (c) 2016 Dalibor Karlović
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Dkarlovi\Luster\Test;

use Dkarlovi\Luster\Reader;
use VirtualFileSystem\FileSystem;

/**
 * Class ReaderTest.
 */
class ReaderTest extends \PHPUnit_Framework_TestCase
{
    /** @var Reader */
    // private $object;

    /**
     * @covers \Dkarlovi\Luster\Reader::__construct
     */
    public function testReadingAnInexistentFileThrowsAnInvalidArgumentException()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(Reader::FILE_INEXISTENT);
        $this->expectExceptionMessage('no such file');
        new Reader('no-such.file');
    }

    /**
     * @covers \Dkarlovi\Luster\Reader::__construct
     */
    public function testReadingAnUnreadableFileThrowsAnInvalidArgumentException()
    {
        $fileSystem = new FileSystem();
        $file = $fileSystem->createFile('/test.log');
        $file->chmod(000);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionCode(Reader::FILE_UNREADABLE);
        $this->expectExceptionMessage('permission denied');
        new Reader($fileSystem->path('/test.log'));
    }

    /**
     * @covers \Dkarlovi\Luster\Reader::__construct
     * @covers \Dkarlovi\Luster\Reader::count
     */
    public function testCanCountNumberOfLinesInAFile()
    {
        $fileSystem = new FileSystem();
        $fileSystem->createFile('/test.log', implode("\n", ['a', 'b', 'c']));

        $reader = new Reader($fileSystem->path('/test.log'));

        self::assertEquals(3, $reader->count());
    }
}
