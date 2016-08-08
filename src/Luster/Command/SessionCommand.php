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

use Dkarlovi\Luster\Reader;
use Dkarlovi\Luster\RequestLog\LogEntry;
use Dkarlovi\Luster\RequestLog\Parser\CombinedLogParser;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\InvalidArgumentException;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class SessionCommand.
 *
 * @author Dalibor Karlović
 */
class SessionCommand extends Command
{
    /**
     * {@inheritdoc}
     *
     * @throws InvalidArgumentException
     */
    protected function configure()
    {
        $this
            ->setName('session')
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
        $reader = new Reader($path);
        $progress = new ProgressBar($output, $reader->count());
        $progress->setRedrawFrequency(200);
        $progress->start();
        $parser = new CombinedLogParser();
        $reader->read(
            [
                function ($line) use ($parser) {
                    return $parser->parse($line);
                },
                function (LogEntry $line) use ($progress) {
                    $progress->advance();

                    return $line;
                },
            ]
        );
        $progress->finish();
        $output->writeln('Done');
        $output->writeln(memory_get_peak_usage(true));
    }
}
