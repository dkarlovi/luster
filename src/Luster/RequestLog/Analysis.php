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
 * Class Analysis.
 */
class Analysis
{
    /** @var \DateTime */
    private $timestampStart;
    /** @var \DateTime */
    private $timestampEnd;
    /** @var int */
    private $total = 0;
    /** @var int */
    private $valid = 0;
    /** @var int[] */
    private $responseCodes = [
        '1xx' => 0,
        '2xx' => 0,
        '3xx' => 0,
        '4xx' => 0,
        '5xx' => 0,
    ];
    /** @var int */
    private $unknownResponseCodes = 0;
    /** @var LogEntry */
    private $latestEntry;

    /**
     * @param LogEntry $entry
     */
    public function ingest(LogEntry $entry)
    {
        $this->latestEntry = $entry;

        $entryTimestamp = $entry->getTimestamp();
        if (null === $this->timestampStart) {
            $this->timestampStart = $entryTimestamp;
            $this->timestampEnd = $entryTimestamp;
        }
        $this->timestampStart = min($this->timestampStart, $entryTimestamp);
        $this->timestampEnd = max($this->timestampStart, $entryTimestamp);

        ++$this->total;
        if (true === $entry->isValid()) {
            ++$this->valid;
        }

        $this->ingestResponseCode($entry->getResponse());
    }

    /**
     * @param int $responseCode
     */
    private function ingestResponseCode($responseCode)
    {
        if (null === $responseCode) {
            ++$this->unknownResponseCodes;
        }
        $class = floor($responseCode / 100).'xx';
        ++$this->responseCodes[$class];
    }
}
