<?php

/*
 * This file is part of Luster.
 *
 * Copyright (c) 2016 Dalibor Karlović
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Dkarlovi\Luster\Scenario;

use Dkarlovi\Luster\RequestLog\LogEntry;

/**
 * Class ScenarioGenerator.
 */
class ScenarioGenerator
{
    /** @var array  */
    private $scenarios = [];

    /** @var int */
    private $scenarioTtl = 300;

    /**
     * @param LogEntry $entry
     *
     * @return string
     */
    public function generateScenarioId(LogEntry $entry)
    {
        // TODO: this needs to be configurable
        $data = implode(' ', [$entry->getClientIp()]);
        $hash = sha1($data);

        $latestTimestamp = $entry->getTimestamp();
        $latestIndex = 0;
        $count = 0;
        if (true === array_key_exists($hash, $this->scenarios)) {
            /** @var \DateTime $previousTimestamp */
            $previousTimestamp = $this->scenarios[$hash]['latestTimestamp'];
            $previousOffset = $latestTimestamp->getTimestamp() - $previousTimestamp->getTimestamp();
            if ($previousOffset >= $this->scenarioTtl) {
                // new session, reset world
                ++$latestIndex;
            }
            ++$count;
        }
        $this->scenarios[$hash] = compact('latestTimestamp', 'latestIndex', 'count');

        return sprintf('%1$s-%2$s', $hash, $latestIndex);
    }
}
