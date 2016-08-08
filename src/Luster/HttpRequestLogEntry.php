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
 * Class HttpRequestLogEntry.
 */
class HttpRequestLogEntry
{
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
     * @return array
     */
    public function getParseErrors()
    {
        return $this->parseErrors;
    }

    /**
     * @param array $parseErrors
     *
     * @return HttpRequestLogEntry
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
        return (bool) $this->parseErrors;
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
     * @return HttpRequestLogEntry
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
     * @return HttpRequestLogEntry
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
     * @return HttpRequestLogEntry
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
     * @param \DateTime $timestamp
     *
     * @return HttpRequestLogEntry
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
     * @return HttpRequestLogEntry
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
     * @return HttpRequestLogEntry
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
     * @return HttpRequestLogEntry
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
     * @return HttpRequestLogEntry
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
     * @return HttpRequestLogEntry
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
     * @return HttpRequestLogEntry
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
     * @return HttpRequestLogEntry
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
     * @return HttpRequestLogEntry
     */
    public function setAgent($agent)
    {
        $this->agent = $agent;

        return $this;
    }
}
