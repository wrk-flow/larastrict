<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Queue\Actions;

use Illuminate\Console\Command;
use Illuminate\Container\Container;
use LaraStrict\Queue\Concerns\UsesCommand;
use LaraStrict\Queue\Interfaces\UsesCommandInterface;
use LaraStrict\Queue\Jobs\Job;

final class CommandJob extends Job implements UsesCommandInterface
{
    use UsesCommand;

    // Test DI
    public function handle(Container $container): ?Command
    {
        return $this->getCommand();
    }
}
