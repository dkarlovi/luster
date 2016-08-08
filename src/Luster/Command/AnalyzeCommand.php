<?php

/*
 * This file is part of Luster.
 *
 * Copyright (c) 2016 Dalibor Karlović
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Dkarlovi\Luster\Command;

use Dkarlovi\Luster\Console\Helper\AnalysisProgressBar;
use Dkarlovi\Luster\Reader;
use Dkarlovi\Luster\RequestLog\Analysis;
use Dkarlovi\Luster\RequestLog\LogEntry;
use Dkarlovi\Luster\RequestLog\Parser\CombinedLogParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SessionCommand.
 *
 * @author Dalibor Karlović
 */
class AnalyzeCommand extends Command
{
    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('analyze')
            ->setDescription('Analyze a log file and extract user session information')
            ->addArgument('path', InputArgument::REQUIRED, 'Path to the access log');
    }

    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $path = $input->getArgument('path');
        try {
            $this->readFileWithProgressBar($output, $path);
        } catch (\InvalidArgumentException $ex) {
            throw new InvalidArgumentException($ex->getMessage(), $ex->getCode());
        }
    }

    /**
     * @param OutputInterface $output
     * @param string          $path
     *
     * @throws \Symfony\Component\Console\Exception\LogicException
     * @throws \InvalidArgumentException
     */
    private function readFileWithProgressBar(OutputInterface $output, $path)
    {
        $parser = new CombinedLogParser();
        $analysis = new Analysis();
        $reader = new Reader($path);
        $progress = new AnalysisProgressBar($analysis, $output, $reader->count());
        $progress->setRedrawFrequency(1234);
        $progress->start();
        $reader->read(
            [
                function ($line) use ($parser) {
                    return $parser->parse($line);
                },
                function (LogEntry $entry) use ($analysis) {
                    $analysis->ingest($entry);

                    return $entry;
                },
                function (LogEntry $entry) use ($progress) {
                    $progress->advance();

                    return $entry;
                },
            ]
        );
        $progress->finish();
        $progress->clear();
        print_r($analysis);
        $output->writeln('Done');
        $output->writeln(memory_get_peak_usage(true));
    }
}
