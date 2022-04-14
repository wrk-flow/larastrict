<?php

declare(strict_types=1);

namespace LaraStrict\Database\Attributes;

class StringAttribute extends AbstractAttribute
{
    public function get(): string
    {
        return $this->getValueFromModel();
    }
}
