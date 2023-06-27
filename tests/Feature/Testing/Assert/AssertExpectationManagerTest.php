<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Assert;

use LaraStrict\Testing\Assert\AssertExpectationManager;
use PHPUnit\Framework\TestCase;

class AssertExpectationManagerTest extends TestCase
{
    public function testSingleton(): void
    {
        $instance = AssertExpectationManager::getInstance();

        $this->assertSame($instance, AssertExpectationManager::getInstance());
    }
}
