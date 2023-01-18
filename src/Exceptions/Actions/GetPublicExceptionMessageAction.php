<?php

declare(strict_types=1);

namespace LaraStrict\Exceptions\Actions;

use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Translation\Translator;
use LaraStrict\Http\Exceptions\MessageHttpExceptionInterface;
use LaraStrict\Http\Exceptions\TranslatableHttpExceptionInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class GetPublicExceptionMessageAction
{
    public function __construct(
        private readonly Container $container,
    ) {
    }

    public function execute(Throwable $exception): ?string
    {
        if ($exception instanceof MessageHttpExceptionInterface) {
            return $exception->getPublicMessage();
        }

        if ($exception instanceof TranslatableHttpExceptionInterface) {
            /** @var Translator $translation */
            $translation = $this->container->make(Translator::class);

            $key = 'exceptions.' . $exception::class;
            $result = $translation->get($key, $exception->getReplaceArrayForTranslation());

            // Prevent exposing internal message if translation is not correctly set
            $missingTranslation = $result === $key;
            if ($missingTranslation) {
                $logger = $this->container->make(LoggerInterface::class);

                $logger->warning('Missing translation for exception under given key', [
                    'key' => $key,
                ]);
            }

            return $missingTranslation ? '' : $result;
        }

        return null;
    }
}
