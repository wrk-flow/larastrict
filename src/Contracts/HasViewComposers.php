<?php

declare(strict_types=1);

namespace LaraStrict\Contracts;

use Illuminate\Contracts\View\Factory;

interface HasViewComposers
{
    public function bootViewComposers(string $serviceName, Factory $viewFactory): void;
}
