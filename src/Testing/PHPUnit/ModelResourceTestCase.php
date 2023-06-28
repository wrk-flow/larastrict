<?php

declare(strict_types=1);

namespace LaraStrict\Testing\PHPUnit;

use Illuminate\Database\Eloquent\Model;
use LaraStrict\Testing\PHPUnit\Traits\MockModels;

/**
 * @template TModel of Model
 * @extends ResourceTestCase<TModel>
 */
abstract class ModelResourceTestCase extends ResourceTestCase
{
    use MockModels;

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockModels();
    }
}
