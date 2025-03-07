<?php declare(strict_types=1);

namespace LaraStrict\Testing\Actions;

use Illuminate\Contracts\Foundation\Application;
use LaraStrict\Testing\Contracts\GetBasePathForAssertsActionContract;

final class GetBasePathForAssertsAction implements GetBasePathForAssertsActionContract
{
    public function __construct(
        private readonly Application $application,
    )
    {
    }


    public function execute(): string
    {
        return $this->application->basePath();
    }
}
