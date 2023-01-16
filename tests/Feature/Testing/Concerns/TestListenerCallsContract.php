<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

interface TestListenerCallsContract
{
    public function handle(TestEvent $event): void;

    public function test(): void;
}
