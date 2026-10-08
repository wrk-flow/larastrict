<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Validation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\MessageBag;

class ValidatorMock implements Validator
{
    /**
     * @param array<array-key, mixed> $validatedData
     */
    public function __construct(
        private readonly array $validatedData,
    ) {
    }

    /**
     * @return array<array-key, mixed>
     */
    public function validate()
    {
        return $this->validatedData;
    }

    /**
     * @return array<array-key, mixed>
     */
    public function validated()
    {
        return $this->validatedData;
    }

    public function fails(): bool
    {
        return false;
    }

    /**
     * @return array<array-key, mixed>
     */
    public function failed()
    {
        return [];
    }

    /**
     * @param array<array-key, mixed> $attribute
     * @param array<array-key, mixed> $rules
     */
    public function sometimes($attribute, $rules, callable $callback)
    {
        return $this;
    }

    public function after($callback)
    {
        return $this;
    }

    public function errors()
    {
        return new MessageBag();
    }

    public function getMessageBag()
    {
        return new MessageBag();
    }
}
