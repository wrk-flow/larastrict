<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand;

interface SimpleActionContract
{
    public function execute(string $first, int $second, bool $third);
}
