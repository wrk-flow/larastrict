<?php

declare(strict_types=1);

namespace LaraStrict\Context\Contracts;

use Closure;
use LaraStrict\Context\Contexts\AbstractContext;
use LaraStrict\Context\Contexts\AbstractIsContext;
use LaraStrict\Context\Values\BoolContextValue;

/**
 * Shareable context values between logic that needs same data. Stored in memory and if context supports its it will
 * stores in cache repository (only usable with boot).
 */
interface ContextServiceContract
{
    public function delete(AbstractContext $context): void;

    /**
     * Stores state to memory (and cache if supported).
     */
    public function set(AbstractContext $context, ContextValueContract $value): void;

    public function setWithoutCache(AbstractContext $context, ContextValueContract $value): void;

    /**
     * @template T of  ContextValueContract
     *
     * @param Closure(mixed...):T $createState
     * @phpstan-param Closure(mixed,mixed,mixed,mixed,mixed,mixed):T $createState
     *
     * @return T
     */
    public function get(AbstractContext $context, Closure $createState): ContextValueContract;

    /**
     * Returns bool state of the context.
     *
     * @param Closure():bool $is
     * @phpstan-param Closure(mixed,mixed,mixed,mixed,mixed,mixed):bool $is
     */
    public function is(AbstractIsContext $context, Closure $is): BoolContextValue;

    public function getCacheKey(AbstractContext $context): string;
}
