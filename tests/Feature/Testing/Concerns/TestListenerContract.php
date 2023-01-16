<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

interface TestListenerContract
{
    public function handle(TestEvent $event): void;
}
