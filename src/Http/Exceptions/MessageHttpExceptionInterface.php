<?php

declare(strict_types=1);

namespace LaraStrict\Http\Exceptions;

use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

interface MessageHttpExceptionInterface extends HttpExceptionInterface
{
    public function getPublicMessage(): string;
}
