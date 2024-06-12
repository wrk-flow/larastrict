<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Entities;

use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;

class AssertFileStateEntity
{
    /**
     * @param array<string, string> $expectationClasses
     */
    public function __construct(
        public readonly PhpFile $file,
        public readonly ClassType $class,
        public readonly Method $constructor,
        public array $expectationClasses = [],
    ) {
    }
}
