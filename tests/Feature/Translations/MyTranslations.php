<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Translations;

use LaraStrict\Translations\AbstractTranslations;

class MyTranslations extends AbstractTranslations
{
    public function getLocalizationKey(): string
    {
        return 'package::test';
    }

    public function getMyTest(): string
    {
        return $this->get(key: 'name');
    }

    public function getAgo(int $number): string
    {
        return $this->getChoice(key: 'minutes_ago', number: $number, replace: [
            'value' => $number,
        ]);
    }

    public function getWays(): array
    {
        return $this->getArray(key: 'ways');
    }

    public function getWay(string $key): string
    {
        return $this->get(key: ['ways', $key]);
    }

    public function getWayArrayKeys(string $key): string
    {
        return $this->get(key: ['ways', $key]);
    }

    public function getWayDotNotation(string $key): string
    {
        return $this->get(key: 'ways.' . $key);
    }

    public function getWayNullable(string $key): ?string
    {
        return $this->getOptional(key: ['ways', $key]);
    }

    public function getNotFoundLaravel(): string
    {
        return $this->get(key: 'test');
    }

    public function getCustomNotFound(): string
    {
        return $this->get(key: 'test', defaultValue: 'test123');
    }

    public function getCustomNotFoundNullable(): ?string
    {
        return $this->getOptional(key: 'test');
    }
}
