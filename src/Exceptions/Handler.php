<?php

declare(strict_types=1);

namespace LaraStrict\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use LaraStrict\Exceptions\Actions\GetPublicExceptionMessageAction;
use Throwable;

class Handler extends ExceptionHandler
{
    protected function convertExceptionToArray(Throwable $e)
    {
        $array = parent::convertExceptionToArray($e);

        /** @var GetPublicExceptionMessageAction $getPublicExceptionMessageAction */
        $getPublicExceptionMessageAction = $this->container->make(GetPublicExceptionMessageAction::class);

        $publicMessage = $getPublicExceptionMessageAction->execute(exception: $e);

        if ($publicMessage !== null) {
            $array['message'] = $publicMessage;
        }

        return $array;
    }
}
