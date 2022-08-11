<?php

declare(strict_types=1);

namespace LaraStrict\Core\Actions;

use Closure;

class PipeAction
{
    /**
     * Return value based on first closure that does not return null.
     *
     * @template T
     *
     * @param array<Closure():(T|null)> $closures
     * @param Closure():T|null   $default
     *
     * @return T|null
     */
    public function execute(array $closures, Closure $default = null): mixed
    {
        foreach ($closures as $closure) {
            $result = $closure();
            if ($result !== null) {
                return $result;
            }
        }

        return $default === null ? null : $default();
    }
}
