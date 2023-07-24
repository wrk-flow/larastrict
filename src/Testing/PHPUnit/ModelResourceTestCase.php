<?php

declare(strict_types=1);

namespace LaraStrict\Testing\PHPUnit;

use LaraStrict\Testing\Concerns\MockModels;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Mockery\Adapter\Phpunit\MockeryTestCaseSetUp;

/**
 * @template TEntity
 * @extends ResourceTestCase<TEntity>
 */
abstract class ModelResourceTestCase extends ResourceTestCase
{
    use MockeryPHPUnitIntegration;
    use MockeryTestCaseSetUp;
    use MockModels;

    protected function mockeryTestSetUp(): void
    {
        $this->mockModels();
    }

    protected function mockeryTestTearDown(): void
    {
    }
}
