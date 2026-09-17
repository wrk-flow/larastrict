<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Actions;

use Tests\LaraStrict\Feature\Providers\Interfaces\TestImplementationInterface;

final readonly class DITestImplementationAction
{
    /**
     * @param array<TestImplementationInterface> $implementations
     */
    public function __construct(
        private array $implementations,
    ) {
    }

    public function execute(): never
    {
        dd($this->implementations);
    }
}
