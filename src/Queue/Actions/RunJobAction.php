<?php

declare(strict_types=1);

namespace LaraStrict\Queue\Actions;

use Illuminate\Console\Command;
use Illuminate\Contracts\Container\Container;
use LaraStrict\Queue\Contracts\RunJobActionContract;
use LaraStrict\Queue\Exceptions\MethodInJobIsNotDefinedException;
use LaraStrict\Queue\Interfaces\UsesCommandInterface;
use LaraStrict\Queue\Jobs\Job;

class RunJobAction implements RunJobActionContract
{
    public function __construct(
        private readonly Container $container
    ) {
    }

    public function execute(Job $job, ?Command $command = null, string $method = null): mixed
    {
        if ($command instanceof Command && $job instanceof UsesCommandInterface) {
            $job->setCommand($command);
        }

        $method ??= 'handle';
        $call = [$job, $method];

        if (is_callable($call) === false) {
            throw new MethodInJobIsNotDefinedException($method, $job::class);
        }

        return $this->container->call($call);
    }
}
