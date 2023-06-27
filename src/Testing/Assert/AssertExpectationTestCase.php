<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Assert;

use LaraStrict\Testing\Assert\Traits\AssertExpectationManagerTrait;
use PHPUnit\Framework\TestCase;

abstract class AssertExpectationTestCase extends TestCase
{
    use AssertExpectationManagerTrait;
}
