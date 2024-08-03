<?php

declare(strict_types=1);

namespace LaraStrict\Console\Jobs;

use h4kuna\Serialize\Serialize;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Output\ConsoleOutput;
use Throwable;

class CommandInQueueJob extends AbstractUniqueLongJob implements ShouldQueue
{
    private array $parameters = [];
    private readonly string $parametersKey;

    /**
     * @param string $command Command signature or class
     */
    public function __construct(
        private readonly string $command,
        array $parameters = [],
        public int $uniqueFor = 1800,
    ) {
        parent::__construct();
        // Calling command in kernel requires key => value structure.
        foreach ($parameters as $key => $value) {
            $this->parameters[$key] = $value;
        }

        ksort($parameters);
        $this->parametersKey = md5(Serialize::encode($parameters));
    }

    public function handle(Kernel $kernel, ConsoleOutput $consoleOutput, LoggerInterface $logger): void
    {
        $startTime = microtime(true);
        $context = [
            'command' => $this->command,
            'parameters' => $this->parameters,
        ];

        try {
            $logger->info('Running command', $context);

            $kernel->call($this->command, $this->parameters, $consoleOutput);

            $logger->info('Command finished', $context + [
                'duration' => microtime(true) - $startTime,
            ]);
        } catch (Throwable $throwable) {
            $logger->error('Command failed', $context + [
                'duration' => microtime(true) - $startTime,
                'message' => $throwable->getMessage(),
            ]);
            throw $throwable;
        }
    }

    public function uniqueId(): string
    {
        return $this->command . $this->parametersKey;
    }
}
