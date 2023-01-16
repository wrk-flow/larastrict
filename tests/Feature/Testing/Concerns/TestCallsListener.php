<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

use PHPUnit\Framework\Assert;

class TestCallsListener implements TestListenerCallsContract
{
    public function handle(TestEvent $event): void
    {
        Assert::fail('Listener should not be called');
    }

    public function test(): void
    {
        Assert::fail('Test should not be called');
    }
}
