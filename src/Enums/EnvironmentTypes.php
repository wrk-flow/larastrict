<?php

declare(strict_types=1);

namespace LaraStrict\Enums;

enum EnvironmentTypes: string
{
    case Production = 'production';
    case Local = 'local';
    case Testing = 'testing';
}
