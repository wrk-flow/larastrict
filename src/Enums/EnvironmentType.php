<?php

declare(strict_types=1);

namespace LaraStrict\Enums;

enum EnvironmentType: string
{
    case Production = 'production';
    case Local = 'local';
    case Testing = 'testing';
}
