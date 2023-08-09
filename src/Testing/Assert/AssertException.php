<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Assert;

use PHPUnit\Exception;
use RuntimeException;

class AssertException extends RuntimeException implements Exception
{

}
