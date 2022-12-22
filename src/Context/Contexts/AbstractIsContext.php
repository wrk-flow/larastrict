<?php

declare(strict_types=1);

namespace LaraStrict\Context\Contexts;

use Closure;
use LaraStrict\Context\Contracts\ContextServiceContract;
use LaraStrict\Context\Values\BoolContextValue;

/**
 * Context allows us to access data across multiple services / actions without loading data again using dependency
 * injection and "memory" context state manager.
 */
abstract class AbstractIsContext extends AbstractContext
{
    public function get(ContextServiceContract $contextService): BoolContextValue
    {
        return $contextService->is($this, $this->is());
    }

    /**
     * @return Closure(mixed...):bool
     * @phpstan-return Closure(mixed,mixed,mixed,mixed,mixed):bool
     */
    abstract public function is(): Closure;
}
