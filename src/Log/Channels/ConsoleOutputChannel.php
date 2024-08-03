<?php

declare(strict_types=1);

namespace LaraStrict\Log\Channels;

use Illuminate\Log\LogManager;
use LaraStrict\Log\Handlers\ConsoleOutputHandler;
use LaraStrict\Log\Managers\ConsoleOutputManager;
use Monolog\Level;
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
            level: self::getLevel($config),
            bubble: self::getBubble($config),
        );

        return new Logger(
            name: $this->parseChannel($config),
            handlers: [$this->prepareHandler($handler, $config)],
        );
    }

    /**
     * @param array<string, mixed>                                                     $config
     */
    private static function getLevel(array $config): Level
    {
        if (array_key_exists('level', $config)) {
            $level = $config['level'];

            if (is_string($level) || is_int($level) || $level instanceof Level) {
                // TODO: I have no clue hot to make PHPStan happy here
                // @phpstan-ignore-next-line
                return Logger::toMonologLevel($level);
            }
        }

        return Level::Debug;
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
