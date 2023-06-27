<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Assert\Traits;

use LaraStrict\Testing\Assert\AssertExpectationManager;

trait AssertExpectationManagerTrait
{
    protected function setUp(): void
    {
        parent::setUp();

        AssertExpectationManager::getInstance()->reset();
    }

    protected function assertPostConditions(): void
    {
        $manager = AssertExpectationManager::getInstance();

        if ($manager->hasExpectations()) {
            $this->addToAssertionCount(1);
            $manager->assertCalled();
        }

        parent::assertPostConditions();
    }

    protected function tearDown(): void
    {
        AssertExpectationManager::getInstance()->reset();

        parent::tearDown();
    }
}
