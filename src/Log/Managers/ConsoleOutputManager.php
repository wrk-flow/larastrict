<?php

declare(strict_types=1);

namespace LaraStrict\Log\Managers;

use Illuminate\Console\Events\CommandFinished;
use Illuminate\Console\Events\CommandStarting;
use Illuminate\Console\OutputStyle;
use Illuminate\Console\View\Components\Factory;
use Illuminate\Contracts\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Log\LogManager;
use Illuminate\Support\Env;
use LaraStrict\Docker\Config\DockerConfig;
use LaraStrict\Log\Channels\ConsoleOutputChannel;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Console output managers allows to output logs to the console when user is running an artisan command.
 * We are able to this by:
 * - listening for artisan command events (starting / finishing)
 * - storing current output in our singleton manager
 * - providing custom log driver that will handle use monolog handler
 * - using a custom stack driver that will use our custom channel and default channel to catch all logs to console /
 * original log
 * - providing our own monolog handler that will use log record and current output to output the log to the console
 */
class ConsoleOutputManager
{
    private const KeyDriver = 'larastrict_console_output_driver';
    private const KeyLoggingConsoleOutput = 'larastrict_console_output';
    private const KeyLoggingOutputStack = 'larastrict_console_output_stack';

    private ?string $previousDefaultDriver = null;
    private ?OutputStyle $outputStyle = null;
    private ?Factory $outputFactory = null;
    private ?OutputInterface $currentOutput = null;

    public function __construct(
        private readonly Application $container,
        private readonly Repository $config,
        private readonly Dispatcher $events,
        private readonly DockerConfig $dockerConfig,
    ) {
    }

    public function setCurrentOutput(?OutputInterface $currentOutput): self
    {
        $this->currentOutput = $currentOutput;

        $this->outputStyle = $currentOutput instanceof OutputInterface
            ? new OutputStyle(new StringInput(''), $currentOutput)
            : null;
        $this->outputFactory = $this->outputStyle instanceof OutputStyle === false
            ? null
            : new Factory($this->outputStyle);

        return $this;
    }

    public function getCurrentOutput(): ?OutputInterface
    {
        return $this->currentOutput;
    }

    public function getOutputStyle(): ?OutputStyle
    {
        return $this->outputStyle;
    }

    public function getOutputFactory(): ?Factory
    {
        return $this->outputFactory;
    }

    /**
     * When user is running an artisan command in terminal (TERM environment variable is set) we want to output any log
     * usage to the console (and to log file).
     */
    public function boot(): void
    {
        // If user is not using terminal, we don't need to do anything. Output all logs to default driver.
        if (Env::get(key: 'TERM') === null) {
            return;
        }

        // Add our driver that will output logs to the console when our manager (singleton) contains
        // current command output.
        // Callback can't be static because laravel binds callback to $this
        $this->getLogManager()
            ->extend(
                driver: self::KeyDriver,
                callback: fn (Application $app, array $config) => (new ConsoleOutputChannel($app))($config),
            );

        // First we need to define our custom console logging channel with custom driver
        // that will output the logs to the console.
        $this->setLoggingChannel(
            key: self::KeyLoggingConsoleOutput,
            config: [
                'driver' => self::KeyDriver,
                'level' => 'debug',
            ],
        );

        $isRunningInDocker = $this->dockerConfig->isInDockerEnvironment();

        $this->events->listen(
            events: [CommandStarting::class],
            listener: function (CommandStarting $event) use ($isRunningInDocker): void {
                $this->setCurrentOutput($event->output);

                $logManager = $this->getLogManager();

                $this->previousDefaultDriver = $logManager->getDefaultDriver();

                // TODO: support config (env) that would disable logging to file (only to console)

                // If we are in docker environment (stderr is used) then we don't want to show the output twice
                if ($this->previousDefaultDriver === 'stderr' && $isRunningInDocker) {
                    $logManager->setDefaultDriver(name: self::KeyLoggingConsoleOutput);
                } else {
                    // By using stack channel we are able to log output to console and to file at the same time.
                    $this->setLoggingChannel(
                        key: self::KeyLoggingOutputStack,
                        config: [
                            'driver' => 'stack',
                            'channels' => [self::KeyLoggingConsoleOutput, $this->previousDefaultDriver],
                        ],
                    );

                    $logManager->setDefaultDriver(name: self::KeyLoggingOutputStack);
                }
            },
        );

        // We are able to detect
        $this->events->listen(
            events: [CommandFinished::class],
            listener: function (): void {
                $this->setCurrentOutput(currentOutput: null);

                if ($this->previousDefaultDriver !== null) {
                    $this->getLogManager()
                        ->setDefaultDriver(name: $this->previousDefaultDriver);
                }
            },
        );
    }

    /**
     * We need to access log manager singleton.
     */
    protected function getLogManager(): LogManager
    {
        return $this->container->make('log');
    }

    /**
     * @param array<string, mixed> $config
     */
    protected function setLoggingChannel(string $key, array $config): void
    {
        $this->config->set('logging.channels.' . $key, $config);
    }
}
