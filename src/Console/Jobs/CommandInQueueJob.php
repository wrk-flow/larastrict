<?php

declare(strict_types=1);

namespace LaraStrict\Console\Jobs;

use Illuminate\Contracts\Console\Kernel;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Throwable;

class CommandInQueueJob extends AbstractUniqueLongJob
{
    public int $uniqueFor = 1800; // Maximum of 30 minutes to process

    private string $command;
    private array $parameters;
    private string $parametersKey;

    /**
     * @param string $command Command signature or class
     */
    public function __construct(string $command, array $parameters = [])
    {
        parent::__construct();

        $this->command = $command;
        $this->parameters = [];
        // We need to build unique id and parameters should be used too
        $parametersKey = '';

        // Calling command in kernel requires key => value structure.
        foreach ($parameters as $key => $value) {
            $this->parameters[$key] = $value;
            $parametersKey .= $key . $value;
        }

        $this->parametersKey = md5($parametersKey);
    }

    public function handle(Kernel $kernel, ConsoleOutput $consoleOutput, LoggerInterface $logger): void
    {
        $startTime = microtime(true);
        $context = ['command' => $this->command, 'parameters' => $this->parameters];

        try {
            $logger->info('Running command', $context);

            $kernel->call($this->command, $this->parameters, $consoleOutput);

            $logger->info('Command finished', $context + ['duration' => microtime(true) - $startTime]);
        } catch (Throwable $exception) {
            $logger->error('Command failed', $context + [
                'duration' => microtime(true) - $startTime,
                'message' => $exception->getMessage(),
            ]);
            throw $exception;
        }
    }

    public function uniqueId(): string
    {
        return $this->command . $this->parametersKey;
    }
}
