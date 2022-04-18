<?php

declare(strict_types=1);

namespace LaraStrict\Context\Contexts;

use Closure;
use LaraStrict\Context\Services\ContextService;
use LaraStrict\Context\Values\BoolContextValue;

/**
 * Context allows us to access data across multiple services / actions without loading data again using dependency
 * injection and "memory" context state manager.
 */
abstract class AbstractIsContext extends AbstractContext
{
    public function get(ContextService $contextService): BoolContextValue
    {
        return $contextService->is($this, $this->is());
    }

    /**
     * @return Closure():bool
     */
    abstract public function is(): Closure;
}
