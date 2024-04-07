<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Validation;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Support\MessageBag;

class ValidatorMock implements Validator
{
    public function __construct(
        private readonly array $validatedData,
    ) {
    }

    public function validate()
    {
        return $this->validatedData;
    }

    public function validated()
    {
        return $this->validatedData;
    }

    public function fails(): bool
    {
        return false;
    }

    public function failed()
    {
        return [];
    }

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
