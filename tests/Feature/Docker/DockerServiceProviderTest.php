<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Docker;

use Closure;
use Illuminate\Console\Events\ScheduledTaskStarting;
use Illuminate\Console\Scheduling\CacheEventMutex;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Contracts\Events\Dispatcher;
use LaraStrict\Docker\Config\DockerConfig;
use LaraStrict\Docker\DockerServiceProvider;
use Tests\LaraStrict\Feature\TestCase;
use const true;

class DockerServiceProviderTest extends TestCase
{
    public function testDockerServiceProviderIsLoaded(): void
    {
        $service = $this->app()
            ->getProvider(DockerServiceProvider::class);
        $this->assertInstanceOf(DockerServiceProvider::class, $service, 'Service provider not registered');
    }

    /**
     * @return array<string|int, array{0: Closure(static):void}>
     */
    public function dataEnsureOutput(): array
    {
        return [
            'will change because it contains default value' => [
                static fn (self $self) => $self->assertEnsureOutput(
                    isInDockerEnvironment: true,
                    expectedDockerOutput: static fn (ScheduledTaskStarting $event) => '/proc/1/fd/1'
                ),
            ],
            'will do nothing because is not in docker env' => [
                static fn (self $self) => $self->assertEnsureOutput(
                    isInDockerEnvironment: false,
                    expectedDockerOutput: static fn (ScheduledTaskStarting $event) => $event->task->getDefaultOutput()
                ),
            ],
            'will do nothing because task output was changed by user using appendOutputTo' => [
                static fn (self $self) => $self->assertEnsureOutput(
                    isInDockerEnvironment: true,
                    expectedDockerOutput: static fn (ScheduledTaskStarting $event) => 'test',
                    setDockerOutput: static function (ScheduledTaskStarting $event) {
                        $event->task->appendOutputTo('test');
                    },
                ),
            ],
            'will do nothing because task output was changed by user using sendOutputTo' => [
                static fn (self $self) => $self->assertEnsureOutput(
                    isInDockerEnvironment: true,
                    expectedDockerOutput: static fn (ScheduledTaskStarting $event) => 'send',
                    setDockerOutput: static function (ScheduledTaskStarting $event) {
                        $event->task->sendOutputTo('send');
                    },
                ),
            ],
        ];
    }

    /**
     * @param Closure(static):void $assert
     *
     * @dataProvider dataEnsureOutput
     */
    public function testEnsureOutput(Closure $assert): void
    {
        $assert($this);
    }

    /**
     * @param Closure(ScheduledTaskStarting):string $expectedDockerOutput
     * @param Closure(ScheduledTaskStarting):void   $setDockerOutput
     */
    public function assertEnsureOutput(
        bool $isInDockerEnvironment,
        Closure $expectedDockerOutput,
        Closure $setDockerOutput = null,
    ): void {
        $app = $this->app();

        $service = $app->getProvider(DockerServiceProvider::class);
        $this->assertInstanceOf(DockerServiceProvider::class, $service, 'Service provider not registered');

        /** @var DockerConfig $config */
        $config = $app->make(DockerConfig::class);
        $config->setIsInDockerEnvironment($isInDockerEnvironment);

        // Re-register to accept new settings
        $app->register(DockerServiceProvider::class, true);

        $eventMutex = $app->make(CacheEventMutex::class);

        $event = new ScheduledTaskStarting(task: new Event(mutex: $eventMutex, command: 'test'));

        if ($setDockerOutput !== null) {
            $setDockerOutput($event);
        }

        /** @var Dispatcher $eventDispatcher */
        $eventDispatcher = $app->make(Dispatcher::class);

        $eventDispatcher->dispatch($event);

        $this->assertEquals($expectedDockerOutput($event), $event->task->output);
    }
}
