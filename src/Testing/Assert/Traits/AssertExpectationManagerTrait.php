<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Assert\Traits;

use LaraStrict\Testing\Assert\AssertExpectationManager;
use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\PostCondition;

trait AssertExpectationManagerTrait
{
    /**
     * @before
     */
    #[Before]
    protected function beforeStartAssertExpectationManager()
    {
        AssertExpectationManager::getInstance()->reset();
    }

    /**
     * @postCondition
     */
    #[PostCondition]
    protected function postConditionStartAssertExpectationManager(): void
    {
        $manager = AssertExpectationManager::getInstance();

        if ($manager->hasExpectations()) {
            $this->addToAssertionCount(1);
            $manager->assertCalled();
        }
    }
}
