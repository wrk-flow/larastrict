<?php

declare(strict_types=1);

namespace LaraStrict\Docker;

use Illuminate\Console\Events\ScheduledTaskStarting;
use Illuminate\Contracts\Events\Dispatcher;
use LaraStrict\Docker\Config\DockerConfig;
use LaraStrict\Providers\AbstractServiceProvider;
use LaraStrict\Providers\Contracts\HasConfig;

class DockerServiceProvider extends AbstractServiceProvider implements HasConfig
{
    public function boot(): void
    {
        parent::boot();

        /** @var DockerConfig $config */
        $config = $this->app->make(DockerConfig::class);

        if ($config->isInDockerEnvironment() === false) {
            return;
        }

        $this->ensureThatLogsAreOutputtedToDockerProcess($config);
    }

    private function ensureThatLogsAreOutputtedToDockerProcess(DockerConfig $config): void
    {
        /** @var Dispatcher $eventDispatcher */
        $eventDispatcher = $this->app->make(Dispatcher::class);

        $eventDispatcher->listen(
            events: [ScheduledTaskStarting::class],
            listener: static function (ScheduledTaskStarting $event) use ($config): void {
                // When we are using stterr as output for logs then schedule tasks will not output
                // any logs  due the /dev/null usage. Let's fix this by appending the output to
                // the docker process.
                if ($event->task->output !== $event->task->getDefaultOutput()) {
                    return;
                }

                $event->task->appendOutputTo($config->getDockerOutputProcess());
            },
        );
    }
}
