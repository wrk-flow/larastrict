<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Translations;

use PHPUnit\Framework\TestCase;
use Tests\LaraStrict\Feature\Providers\Translations\TestTranslation;

class AbstractProviderTranslationsTest extends TestCase
{
    private TestTranslation $translation;

    protected function setUp(): void
    {
        parent::setUp();
        $this->translation = TestTranslation::forTests();
    }

    public function testGet(): void
    {
        $this->assertEquals('Test::test.test', $this->translation->getTest());
    }
}
