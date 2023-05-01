<?php

declare(strict_types=1);

namespace LaraStrict\Log\Channels;

use Illuminate\Log\LogManager;
use LaraStrict\Log\Handlers\ConsoleOutputHandler;
use LaraStrict\Log\Managers\ConsoleOutputManager;
use Monolog\Logger;

/**
 * @internal
 */
final class ConsoleOutputChannel extends LogManager
{
    /**
     * @param array<string, mixed> $config
     */
    public function __invoke(array $config): Logger
    {
        $handler = new ConsoleOutputHandler(
            manager: $this->app->make(ConsoleOutputManager::class),
            level: $config['level'] ?? Logger::DEBUG,
            bubble: $config['bubble'] ?? true,
        );

        return new Logger(
            name: $this->parseChannel($config),
            handlers: [$this->prepareHandler($handler, $config)]
        );
    }
}
