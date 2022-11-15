<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Translations;

use Tests\LaraStrict\Feature\TestCase;

class AbstractTranslationsTest extends TestCase
{
    private MyTranslations $translations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->app()
            ->register(TranslationServiceProvider::class);

        $this->translations = $this->app()
            ->make(MyTranslations::class);
    }

    public function testGetString(): void
    {
        $this->assertEquals('test', $this->translations->getMyTest());
    }

    public function testChoice(): void
    {
        $this->assertEquals('1 minute ago', $this->translations->getAgo(1));
        $this->assertEquals('2 minutes ago', $this->translations->getAgo(2));
        $this->assertEquals('5 minutes ago', $this->translations->getAgo(5));
    }

    public function testArray(): void
    {
        $expected = [
            'one' => 'One way',
            'two' => 'Two way',
        ];
        $this->assertEquals($expected, $this->translations->getWays());
    }

    public function testDefaultValueByLaravel(): void
    {
        $this->assertEquals('package::test.test', $this->translations->getNotFoundLaravel());
    }

    public function testCustomDefaultValue(): void
    {
        $this->assertEquals('test123', $this->translations->getCustomNotFound());
    }
}
