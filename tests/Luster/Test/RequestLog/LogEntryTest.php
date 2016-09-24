<?php

/*
 * This file is part of Luster.
 *
 * Copyright (c) 2016 Dalibor Karlović
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Dkarlovi\Luster\Test\RequestLog;

use Dkarlovi\Luster\RequestLog\LogEntry;

/**
 * Class LogEntryTest.
 */
class LogEntryTest extends \PHPUnit_Framework_TestCase
{
    /** @var LogEntry */
    private $object;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        $this->object = new LogEntry('1.2.3.4 - - [01/Jan/2000:00:00:00 +0000] "GET / HTTP/1.1" 200 100 "-" "-"');
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::__construct
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::getRawLogEntry
     */
    public function testCanGetRawLogEntry()
    {
        $rawEntry = '1.2.3.4 - - [01/Jan/2000:00:00:00 +0000] "GET / HTTP/1.1" 200 100 "-" "-"';
        $object = new LogEntry($rawEntry);
        self::assertEquals($rawEntry, $object->getRawLogEntry());
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::setScenarioId
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::getScenarioId
     *
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry::__construct
     */
    public function testCanSetAndGetScenarioId()
    {
        $this->object->setScenarioId('scenario-1');
        self::assertEquals('scenario-1', $this->object->getScenarioId());
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::setParseErrors
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::getParseErrors
     *
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry::__construct
     */
    public function testCanSetAndGetParseErrors()
    {
        $this->object->setParseErrors(['error1', 'error2']);
        self::assertEquals(['error1', 'error2'], $this->object->getParseErrors());
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::isValid
     *
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry::__construct
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry::setParseErrors
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry::getParseErrors
     */
    public function testIsNotValidIfItHasParseErrors()
    {
        $this->object->setParseErrors(['error1', 'error2']);
        self::assertFalse($this->object->isValid());
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::setClientIp
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::getClientIp
     *
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry::__construct
     */
    public function testCanSetAndGetClientIp()
    {
        $this->object->setClientIp('1.2.3.4');
        self::assertEquals('1.2.3.4', $this->object->getClientIp());
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::setIdent
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::getIdent
     *
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry::__construct
     */
    public function testCanSetAndGetIdent()
    {
        $this->object->setIdent('user@EXAMPLE.COM');
        self::assertEquals('user@EXAMPLE.COM', $this->object->getIdent());
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::setAuth
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::getAuth
     *
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry::__construct
     */
    public function testCanSetAndGetUser()
    {
        $this->object->setAuth('user');
        self::assertEquals('user', $this->object->getAuth());
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::setTimestamp
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::getTimestamp
     *
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry::__construct
     */
    public function testCanSetAndGetTimestamp()
    {
        $timestamp = new \DateTime();
        $this->object->setTimestamp($timestamp);
        self::assertEquals($timestamp, $this->object->getTimestamp());
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::setVerb
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::getVerb
     *
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry::__construct
     */
    public function testCanSetAndGetVerb()
    {
        $this->object->setVerb('POST');
        self::assertEquals('POST', $this->object->getVerb());
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::setRequest
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::getRequest
     *
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry::__construct
     */
    public function testCanSetAndGetRequest()
    {
        $this->object->setRequest('/foo/eee');
        self::assertEquals('/foo/eee', $this->object->getRequest());
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::setVersion
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::getVersion
     *
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry::__construct
     */
    public function testCanSetAndGetVersion()
    {
        $this->object->setVersion('1.1');
        self::assertEquals('1.1', $this->object->getVersion());
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::setRawRequest
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::getRawRequest
     *
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry::__construct
     */
    public function testCanSetAndGetRawRequest()
    {
        $this->object->setRawRequest('/raw/foo/eee');
        self::assertEquals('/raw/foo/eee', $this->object->getRawRequest());
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::setResponse
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::getResponse
     *
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry::__construct
     */
    public function testCanSetAndGetResponse()
    {
        $this->object->setResponse(200);
        self::assertEquals(200, $this->object->getResponse());
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::setBytes
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::getBytes
     *
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry::__construct
     */
    public function testCanSetAndGetBytes()
    {
        $this->object->setBytes(123);
        self::assertEquals(123, $this->object->getBytes());
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::setReferrer
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::getReferrer
     *
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry::__construct
     */
    public function testCanSetAndGetReferrer()
    {
        $this->object->setReferrer('http://www.example.com/');
        self::assertEquals('http://www.example.com/', $this->object->getReferrer());
    }

    /**
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::setAgent
     * @covers \Dkarlovi\Luster\RequestLog\LogEntry::getAgent
     *
     * @uses   \Dkarlovi\Luster\RequestLog\LogEntry::__construct
     */
    public function testCanSetAndGetAgent()
    {
        $this->object->setAgent('Mozilla/5.0');
        self::assertEquals('Mozilla/5.0', $this->object->getAgent());
    }
}
