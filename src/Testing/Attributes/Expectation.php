<?php declare(strict_types=1);

namespace LaraStrict\Testing\Attributes;

#[\Attribute]
final class Expectation
{
    public function __construct(
        string $class,
    )
    {
    }
}
