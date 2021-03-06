<?php

/*
 * This file is part of Luster.
 *
 * Copyright (c) 2016 Dalibor Karlović
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Dkarlovi\Luster\RequestLog\Parser;

use Dkarlovi\Luster\RequestLog\LogEntry;

/**
 * Class CombinedLogParser.
 */
class CombinedLogParser
{
    /** @var string */
    private $line = '(?<clientip>(?:(?:((([0-9A-Fa-f]{1,4}:){7}([0-9A-Fa-f]{1,4}|:))|(([0-9A-Fa-f]{1,4}:){6}(:[0-9A-Fa-f]{1,4}|((25[0-5]|2[0-4]\\d|1\\d\\d|[1-9]?\\d)(\\.(25[0-5]|2[0-4]\\d|1\\d\\d|[1-9]?\\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){5}(((:[0-9A-Fa-f]{1,4}){1,2})|:((25[0-5]|2[0-4]\\d|1\\d\\d|[1-9]?\\d)(\\.(25[0-5]|2[0-4]\\d|1\\d\\d|[1-9]?\\d)){3})|:))|(([0-9A-Fa-f]{1,4}:){4}(((:[0-9A-Fa-f]{1,4}){1,3})|((:[0-9A-Fa-f]{1,4})?:((25[0-5]|2[0-4]\\d|1\\d\\d|[1-9]?\\d)(\\.(25[0-5]|2[0-4]\\d|1\\d\\d|[1-9]?\\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){3}(((:[0-9A-Fa-f]{1,4}){1,4})|((:[0-9A-Fa-f]{1,4}){0,2}:((25[0-5]|2[0-4]\\d|1\\d\\d|[1-9]?\\d)(\\.(25[0-5]|2[0-4]\\d|1\\d\\d|[1-9]?\\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){2}(((:[0-9A-Fa-f]{1,4}){1,5})|((:[0-9A-Fa-f]{1,4}){0,3}:((25[0-5]|2[0-4]\\d|1\\d\\d|[1-9]?\\d)(\\.(25[0-5]|2[0-4]\\d|1\\d\\d|[1-9]?\\d)){3}))|:))|(([0-9A-Fa-f]{1,4}:){1}(((:[0-9A-Fa-f]{1,4}){1,6})|((:[0-9A-Fa-f]{1,4}){0,4}:((25[0-5]|2[0-4]\\d|1\\d\\d|[1-9]?\\d)(\\.(25[0-5]|2[0-4]\\d|1\\d\\d|[1-9]?\\d)){3}))|:))|(:(((:[0-9A-Fa-f]{1,4}){1,7})|((:[0-9A-Fa-f]{1,4}){0,5}:((25[0-5]|2[0-4]\\d|1\\d\\d|[1-9]?\\d)(\\.(25[0-5]|2[0-4]\\d|1\\d\\d|[1-9]?\\d)){3}))|:)))(%.+)?|(?<![0-9])(?:(?:[0-1]?[0-9]{1,2}|2[0-4][0-9]|25[0-5])[.](?:[0-1]?[0-9]{1,2}|2[0-4][0-9]|25[0-5])[.](?:[0-1]?[0-9]{1,2}|2[0-4][0-9]|25[0-5])[.](?:[0-1]?[0-9]{1,2}|2[0-4][0-9]|25[0-5]))(?![0-9]))|\\b(?:[0-9A-Za-z][0-9A-Za-z-]{0,62})(?:\\.(?:[0-9A-Za-z][0-9A-Za-z-]{0,62}))*(\\.?|\\b))) (?<ident>[a-zA-Z][a-zA-Z0-9_.+-=:]+@\\b(?:[0-9A-Za-z][0-9A-Za-z-]{0,62})(?:\\.(?:[0-9A-Za-z][0-9A-Za-z-]{0,62}))*(\\.?|\\b)|[a-zA-Z0-9._-]+) (?<auth>[a-zA-Z0-9._-]+) \\[(?<timestamp>(?:(?:0[1-9])|(?:[12][0-9])|(?:3[01])|[1-9])/\\b(?:[Jj]an(?:uary|uar)?|[Ff]eb(?:ruary|ruar)?|[Mm](?:a|ä)?r(?:ch|z)?|[Aa]pr(?:il)?|[Mm]a(?:y|i)?|[Jj]un(?:e|i)?|[Jj]ul(?:y)?|[Aa]ug(?:ust)?|[Ss]ep(?:tember)?|[Oo](?:c|k)?t(?:ober)?|[Nn]ov(?:ember)?|[Dd]e(?:c|z)(?:ember)?)\\b/(?>\\d\\d){1,2}:(?!<[0-9])(?:2[0123]|[01]?[0-9]):(?:[0-5][0-9])(?::(?:(?:[0-5]?[0-9]|60)(?:[:.,][0-9]+)?))(?![0-9]) (?:[+-]?(?:[0-9]+)))\\] "(?:(?<verb>\\b\\w+\\b) (?<request>\\S+)(?: HTTP/(?<httpversion>(?:(?<![0-9.+-])(?>[+-]?(?:(?:[0-9]+(?:\\.[0-9]+)?)|(?:\\.[0-9]+))))))?|(?<rawrequest>.*?))" (?<response>(?:(?<![0-9.+-])(?>[+-]?(?:(?:[0-9]+(?:\\.[0-9]+)?)|(?:\\.[0-9]+))))) (?:(?<bytes>(?:(?<![0-9.+-])(?>[+-]?(?:(?:[0-9]+(?:\\.[0-9]+)?)|(?:\\.[0-9]+)))))|-) (?<referrer>(?>(?<!\\\\)(?>"(?>\\\\.|[^\\\\"]+)+"|""|(?>\'(?>\\\\.|[^\\\\\']+)+\')|\'\'|(?>`(?>\\\\.|[^\\\\`]+)+`)|``))) (?<agent>(?>(?<!\\\\)(?>"(?>\\\\.|[^\\\\"]+)+"|""|(?>\'(?>\\\\.|[^\\\\\']+)+\')|\'\'|(?>`(?>\\\\.|[^\\\\`]+)+`)|``)))';

    /** @var string */
    private $dateFormat = 'd/M/Y:H:i:s +T';

    /** @var string */
    private $optimized;

    /**
     * Parser constructor.
     */
    public function __construct()
    {
        $this->optimized = sprintf('/^%1$s$/s', addcslashes($this->line, '/'));
    }

    /**
     * @param string $line
     *
     * @return LogEntry
     */
    public function parse($line)
    {
        $logEntry = new LogEntry($line);
        $errors = ['Parsing failure'];
        if (true === (bool) preg_match($this->optimized, $line, $parsed)) {
            $errors = [];
            $logEntry
                ->setClientIp($parsed['clientip'])
                ->setIdent($this->filter($parsed['ident']))
                ->setAuth($this->filter($parsed['auth']))
                ->setTimestamp($this->formatDateTime($parsed['timestamp'], $errors, 'timestamp'))
                ->setVerb($parsed['verb'])
                ->setRequest($parsed['request'])
                ->setVersion($parsed['httpversion'])
                ->setRawRequest($this->filter($parsed['rawrequest']))
                ->setResponse((int) $parsed['response'])
                ->setBytes((int) $parsed['bytes'])
                ->setReferrer($this->filter($parsed['referrer']))
                ->setAgent($this->filter($parsed['agent']));
        }
        $logEntry->setParseErrors($errors);

        return $logEntry;
    }

    /**
     * @param string $value
     *
     * @return null|string
     */
    private function filter($value)
    {
        $value = trim($value, '"');
        if ('' === $value || '-' === $value) {
            return null;
        }

        return $value;
    }

    /**
     * @param string $timestamp
     * @param array  $errors
     * @param string $name
     *
     * @return \DateTime|null
     */
    private function formatDateTime($timestamp, array &$errors, $name)
    {
        $dateTime = date_create_from_format($this->dateFormat, $timestamp);
        $report = date_get_last_errors();
        if (0 < $report['error_count'] || 0 < $report['warning_count']) {
            $errors[$name] = array_merge($report['errors'], $report['warnings']);
            $dateTime = null;
        }

        return $dateTime;
    }
}
