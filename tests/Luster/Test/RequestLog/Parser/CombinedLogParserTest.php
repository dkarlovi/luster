<?php

/*
 * This file is part of Luster.
 *
 * Copyright (c) 2016 Dalibor Karlović
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Dkarlovi\Luster\Test\RequestLog\Parser;

use Dkarlovi\Luster\RequestLog\LogEntry;
use Dkarlovi\Luster\RequestLog\Parser\CombinedLogParser;

/**
 * Class CombinedLogParserTest.
 */
class CombinedLogParserTest extends \PHPUnit_Framework_TestCase
{
    /** @var CombinedLogParser */
    private $object;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->object = new CombinedLogParser();
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\Parser\CombinedLogParser::__construct
     * @covers \Dkarlovi\Luster\RequestLog\Parser\CombinedLogParser::parse
     * @covers \Dkarlovi\Luster\RequestLog\Parser\CombinedLogParser::<private>
     *
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry
     */
    public function testCanParseCombinedLogEntry()
    {
        /** @var LogEntry $entry */
        $entry = $this->object->parse(
            '1.2.3.4 user@EXAMPLE.COM user [31/Jan/1987:11:12:13 +0200] "GET / HTTP/1.1" 200 123 "http://example.com/" "Mozilla/5.0"'
        );
        $dateTime = new \DateTime('1987-01-31 11:12:13 +02:00');

        self::assertInstanceOf(LogEntry::class, $entry);
        self::assertTrue($entry->isValid());
        self::assertSame('1.2.3.4', $entry->getClientIp());
        self::assertSame('user@EXAMPLE.COM', $entry->getIdent());
        self::assertSame('user', $entry->getAuth());
        self::assertEquals($dateTime, $entry->getTimestamp());
        self::assertSame('GET', $entry->getVerb());
        self::assertSame('/', $entry->getRequest());
        self::assertSame('1.1', $entry->getVersion());
        self::assertNull($entry->getRawRequest());
        self::assertSame(200, $entry->getResponse());
        self::assertSame(123, $entry->getBytes());
        self::assertSame('http://example.com/', $entry->getReferrer());
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\Parser\CombinedLogParser::parse
     * @covers \Dkarlovi\Luster\RequestLog\Parser\CombinedLogParser::<private>
     *
     * @uses   \Dkarlovi\Luster\RequestLog\Parser\CombinedLogParser::__construct
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry
     */
    public function testWillMarkUnparseableInputAsInvalid()
    {
        $entry = $this->object->parse('this / is $UNPARSEABLE!');

        static::assertFalse($entry->isValid());
        static::assertSame(['Parsing failure'], $entry->getParseErrors());
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\Parser\CombinedLogParser::parse
     * @covers \Dkarlovi\Luster\RequestLog\Parser\CombinedLogParser::<private>
     *
     * @uses   \Dkarlovi\Luster\RequestLog\Parser\CombinedLogParser::__construct
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry
     */
    public function testWillMarkUnparseableTimestampAsInvalid()
    {
        // everything is valid except the date
        $entry = $this->object->parse(
            '1.2.3.4 user@EXAMPLE.COM user [31/Feb/1987:11:12:13 +0200] "GET / HTTP/1.1" 200 123 "http://example.com/" "Mozilla/5.0"'
        );
        static::assertFalse($entry->isValid());
        static::assertSame(['timestamp' => ['The parsed date was invalid']], $entry->getParseErrors());
    }
}
