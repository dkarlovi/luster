<?php

/*
 * This file is part of Luster.
 *
 * Copyright (c) 2016 Dalibor Karlović
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Dkarlovi\Luster\RequestLog;

/**
 * Class LogEntry.
 */
class LogEntry
{
    /** @var string */
    private $scenarioId;
    /** @var string */
    private $rawLogEntry;
    /** @var array */
    private $parseErrors;
    /** @var string */
    private $clientIp;
    /** @var string */
    private $ident;
    /** @var string */
    private $auth;
    /** @var \DateTime */
    private $timestamp;
    /** @var string */
    private $verb;
    /** @var string */
    private $request;
    /** @var string */
    private $version;
    /** @var string */
    private $rawRequest;
    /** @var int */
    private $response;
    /** @var int */
    private $bytes;
    /** @var string */
    private $referrer;
    /** @var string */
    private $agent;

    /**
     * LogEntry constructor.
     *
     * @param string $rawLogEntry
     */
    public function __construct($rawLogEntry)
    {
        $this->rawLogEntry = $rawLogEntry;
    }

    /**
     * @return string
     */
    public function getScenarioId()
    {
        return $this->scenarioId;
    }

    /**
     * @param string $scenarioId
     */
    public function setScenarioId($scenarioId)
    {
        $this->scenarioId = $scenarioId;
    }

    /**
     * @return string
     */
    public function getRawLogEntry()
    {
        return $this->rawLogEntry;
    }

    /**
     * @return array
     */
    public function getParseErrors()
    {
        return $this->parseErrors;
    }

    /**
     * @param array $parseErrors
     *
     * @return LogEntry
     */
    public function setParseErrors(array $parseErrors)
    {
        $this->parseErrors = $parseErrors;

        return $this;
    }

    /**
     * @return bool
     */
    public function isValid()
    {
        return !$this->parseErrors;
    }

    /**
     * @return string
     */
    public function getClientIp()
    {
        return $this->clientIp;
    }

    /**
     * @param string $clientIp
     *
     * @return LogEntry
     */
    public function setClientIp($clientIp)
    {
        $this->clientIp = $clientIp;

        return $this;
    }

    /**
     * @return string
     */
    public function getIdent()
    {
        return $this->ident;
    }

    /**
     * @param string $ident
     *
     * @return LogEntry
     */
    public function setIdent($ident)
    {
        $this->ident = $ident;

        return $this;
    }

    /**
     * @return string
     */
    public function getAuth()
    {
        return $this->auth;
    }

    /**
     * @param string $auth
     *
     * @return LogEntry
     */
    public function setAuth($auth)
    {
        $this->auth = $auth;

        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param \DateTime|null $timestamp
     *
     * @return LogEntry
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @return string
     */
    public function getVerb()
    {
        return $this->verb;
    }

    /**
     * @param string $verb
     *
     * @return LogEntry
     */
    public function setVerb($verb)
    {
        $this->verb = $verb;

        return $this;
    }

    /**
     * @return string
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param string $request
     *
     * @return LogEntry
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     *
     * @return LogEntry
     */
    public function setVersion($version)
    {
        $this->version = $version;

        return $this;
    }

    /**
     * @return string
     */
    public function getRawRequest()
    {
        return $this->rawRequest;
    }

    /**
     * @param string $rawRequest
     *
     * @return LogEntry
     */
    public function setRawRequest($rawRequest)
    {
        $this->rawRequest = $rawRequest;

        return $this;
    }

    /**
     * @return int
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param int $response
     *
     * @return LogEntry
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }

    /**
     * @return int
     */
    public function getBytes()
    {
        return $this->bytes;
    }

    /**
     * @param int $bytes
     *
     * @return LogEntry
     */
    public function setBytes($bytes)
    {
        $this->bytes = $bytes;

        return $this;
    }

    /**
     * @return string
     */
    public function getReferrer()
    {
        return $this->referrer;
    }

    /**
     * @param string $referrer
     *
     * @return LogEntry
     */
    public function setReferrer($referrer)
    {
        $this->referrer = $referrer;

        return $this;
    }

    /**
     * @return string
     */
    public function getAgent()
    {
        return $this->agent;
    }

    /**
     * @param string $agent
     *
     * @return LogEntry
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;

        return $this;
    }
}
