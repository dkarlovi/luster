<?php

/*
 * This file is part of Luster.
 *
 * Copyright (c) 2016 Dalibor Karlović
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Dkarlovi\Luster\Console\Helper;

use Dkarlovi\Luster\RequestLog\Analysis;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AnalysisProgressBar.
 */
class AnalysisProgressBar extends ProgressBar
{
    /** @var Analysis */
    private $analysis;

    /**
     * AnalysisProgressBar constructor.
     *
     * @param Analysis        $analysis
     * @param OutputInterface $output
     * @param int             $max
     */
    public function __construct(Analysis $analysis, OutputInterface $output, $max)
    {
        $this->analysis = $analysis;
        /*
        $length = Helper::strlen($max);
        $this->setBarCharacter('<comment>=</comment>');
        $this->setEmptyBarCharacter(' ');
        $this->setProgressCharacter('o');
        static::setFormatDefinition(
            'normal',
            sprintf(
                'Start:   %%start%%'
                ."\n".'End:     %%end%%'
                ."\n".'Total:   %%total:%1$ss%%'
                ."\n".'Valid:   %%valid:%1$ss%%'
                ."\n".'Invalid: %%invalid:%1$ss%%'
                ."\n".'Codes:  '
                .' <fg=white;bg=magenta>1xx</>'
                .' <fg=white;bg=green>2xx</>'
                .' <fg=white;bg=blue>3xx</>'
                .' <fg=black;bg=yellow>4xx</>'
                .' <fg=white;bg=red>5xx</>'
                ."\n".'%%bar%%'
                ."\n".'%%request%%',
                $length
            )
        );
        */

        parent::__construct($output, $max);
    }

    /**
     * {@inheritdoc}
     */
    public function advance($step = 1)
    {
        $this->setMessage(
            $this->analysis->latestEntry->getVerb().' '.$this->analysis->latestEntry->getRequest(),
            'request'
        );
        $this->setMessage($this->analysis->timestampStart->format('c'), 'start');
        $this->setMessage($this->analysis->timestampEnd->format('c'), 'end');
        $this->setMessage($this->analysis->total, 'total');
        $this->setMessage($this->analysis->valid, 'valid');
        $this->setMessage($this->analysis->total - $this->analysis->valid, 'invalid');

        parent::advance($step);
    }
}
