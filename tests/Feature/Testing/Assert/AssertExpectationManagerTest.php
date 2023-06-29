<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Assert;

use LaraStrict\Testing\Assert\AssertExpectationManager;
use PHPUnit\Framework\TestCase;

class AssertExpectationManagerTest extends TestCase
{
    public function testSingleton(): void
    {
        // Singleton is initialized in different test case.
        AssertExpectationManager::resetSingleton();

        $instance = AssertExpectationManager::getInstance();

        $this->assertSame($instance, AssertExpectationManager::getInstance());
    }
}
