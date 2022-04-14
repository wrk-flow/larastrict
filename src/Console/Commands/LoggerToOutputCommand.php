<?php

declare(strict_types=1);

namespace LaraStrict\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use LaraStrict\Logger\Services\LogToOutputService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\StyleInterface;

abstract class LoggerToOutputCommand extends Command
{
    /**
     * Swap logger interface to ouptut all values to output.
     *
     * @throws BindingResolutionException
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // TODO detect when running in queue and use logger interface.

        if (($output instanceof StyleInterface) === true) {
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
