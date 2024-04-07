<?php

declare(strict_types=1);

namespace LaraStrict\Log\Channels;

use Illuminate\Log\LogManager;
use LaraStrict\Log\Handlers\ConsoleOutputHandler;
use LaraStrict\Log\Managers\ConsoleOutputManager;
use Monolog\Logger;
use Psr\Log\LogLevel;

/**
 * @internal
 * @phpstan-import-type LevelName from Logger
 * @phpstan-import-type Level from Logger
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
            level: self::getLevel($config),
            bubble: self::getBubble($config),
        );

        return new Logger(
            name: $this->parseChannel($config),
            handlers: [$this->prepareHandler($handler, $config)]
        );
    }

    /**
     * @param array<string, mixed> $config
     *
     * @phpstan-return Level|LevelName|LogLevel::*
     */
    private static function getLevel(array $config): int|string
    {
        if (array_key_exists('level', $config)) {
            $level = $config['level'];

            if (is_string($level) || is_int($level)) {
                return $level;
            }
        }

        return Logger::DEBUG;
    }

    /**
     * @param array<string, mixed> $config
     */
    private static function getBubble(array $config): bool
    {
        if (array_key_exists('bubble', $config)) {
            $bubble = $config['bubble'];

            if (is_string($bubble) || is_int($bubble) || is_bool($bubble)) {
                return (bool) $bubble;
            }
        }

        return true;
    }
}
