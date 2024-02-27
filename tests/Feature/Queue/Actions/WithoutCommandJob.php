<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Queue\Actions;

use Illuminate\Container\Container;
use LaraStrict\Queue\Jobs\Job;

final class WithoutCommandJob extends Job
{
    public function __construct(
        private readonly string $name,
    ) {
        parent::__construct();
    }

    public function getName(): string
    {
        return $this->name;
    }

    // Test DI
    public function handle(Container $container): string
    {
        return $this->name;
    }
}
