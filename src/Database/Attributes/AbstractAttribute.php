<?php

declare(strict_types=1);

namespace LaraStrict\Database\Attributes;

use Illuminate\Database\Eloquent\Model;

abstract class AbstractAttribute
{
    public readonly string $name;

    public function __construct(
        public readonly ?Model $model = null,
        ?string $name = null
) {
        if ($name === null) {
            $stack = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
            $this->name = $stack[1]['function'];
        } else {
            $this->name = $name;
        }

        // if ($this->model === )
    }

    protected function getValueFromModel(): mixed
    {
        // TODO exception
        if ($this->model === null) {
            return null;
        }

        return $this->model->getAttribute($this->name);
    }

    abstract public function get(): mixed;
}
