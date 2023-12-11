<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Actions;

use Tests\LaraStrict\Feature\Providers\Interfaces\TestImplementationInterface;

final class DITestImplementationAction
{
    /**
     * @param array<TestImplementationInterface> $implementations
     */
    public function __construct(
        private readonly array $implementations,
    ) {
    }

    public function execute(): never
    {
        dd($this->implementations);
    }
}
