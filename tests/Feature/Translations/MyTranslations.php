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
        return $this->get('name');
    }

    public function getAgo(int $number): string
    {
        return $this->getChoice('minutes_ago', $number, [
            'value' => $number,
        ]);
    }

    public function getWays(): array
    {
        return $this->getArray('ways');
    }
}
