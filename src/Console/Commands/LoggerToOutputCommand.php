<?php

declare(strict_types=1);

namespace LaraStrict\Console\Commands;

use Illuminate\Console\Command;
use LaraStrict\Logger\Services\LogToOutputService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;

abstract class LoggerToOutputCommand extends Command
{
    /**
     * Swap logger interface to output all values to output of command I've triggered.
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // TODO: we need to detect using events if we are in queue or in schedule
        if ($output instanceof StyleInterface) {
            $loggerBefore = $this->laravel->make(LoggerInterface::class);
            $logToOutputService = new LogToOutputService($output);
            $this->laravel->instance(LoggerInterface::class, $logToOutputService);

            $result = parent::execute($input, $output);

            $this->laravel->instance(LoggerInterface::class, $loggerBefore);

            return $result;
        }

        return parent::execute($input, $output);
    }
}
