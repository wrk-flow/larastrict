<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Translations;

use PHPUnit\Framework\TestCase;
use Tests\LaraStrict\Feature\Translations\MyTranslations;

class AbstractTranslationsTest extends TestCase
{
    final public const ExpectedArray = [
        'one' => 'One way',
        'two' => 'Two way',
    ];

    private MyTranslations $translations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->translations = MyTranslations::forTests([
            'package::test.ways' => self::ExpectedArray,
        ]);
    }

    public function testGetString(): void
    {
        $this->assertEquals('package::test.name', $this->translations->getMyTest());
    }

    public function testChoice(): void
    {
        $this->assertEquals('package::test.minutes_ago:1:r:1', $this->translations->getAgo(1));
        $this->assertEquals('package::test.minutes_ago:2:r:2', $this->translations->getAgo(2));
        $this->assertEquals('package::test.minutes_ago:5:r:5', $this->translations->getAgo(5));
    }

    public function testArray(): void
    {
        $this->assertEquals(self::ExpectedArray, $this->translations->getWays());
    }

    public function testGetWay(): void
    {
        $this->assertEquals('package::test.ways.one', $this->translations->getWay('one'));
        $this->assertEquals('package::test.ways.two', $this->translations->getWay('two'));
    }

    public function testGetWayWithArrayKeys(): void
    {
        $this->assertEquals('package::test.ways.one', $this->translations->getWayArrayKeys('one'));
        $this->assertEquals('package::test.ways.two', $this->translations->getWayArrayKeys('two'));
    }

    public function testGetWayNullableAlwaysReturnsNullBecauseSameKeyIsReturned(): void
    {
        $this->assertEquals(null, $this->translations->getWayNullable('one'));
        $this->assertEquals(null, $this->translations->getWayNullable('two'));
        $this->assertEquals(null, $this->translations->getWayNullable('s'));
    }

    public function testDefaultValueByLaravel(): void
    {
        $this->assertEquals('package::test.test', $this->translations->getNotFoundLaravel());
    }

    public function testCustomDefaultValue(): void
    {
        $this->assertEquals('test123', $this->translations->getCustomNotFound());
    }

    public function testCustomDefaultNullValue(): void
    {
        $this->assertEquals(null, $this->translations->getCustomNotFoundNullable());
    }
}
