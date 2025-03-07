<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Factories;

use LaraStrict\Testing\Actions\ComposerAutoloadAbsoluteAction;
use LaraStrict\Testing\Contracts\FinderFactoryContract;
use Symfony\Component\Finder\Finder;

final class FinderFactory implements FinderFactoryContract
{
    public function __construct(
        private readonly ComposerAutoloadAbsoluteAction $composerAutoloadAbsoluteAction,
    ) {
    }

    public function create(): Finder
    {
        return Finder::create()->files()
            ->name('*.php')
            ->in($this->composerAutoloadAbsoluteAction->execute())
            ->notName('*.blade.php');
    }
}
