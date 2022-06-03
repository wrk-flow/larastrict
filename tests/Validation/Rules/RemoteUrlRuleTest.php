<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Validation\Rules;

use LaraStrict\Validation\Rules\RemoteUrlRule;
use PHPUnit\Framework\TestCase;

class RemoteUrlRuleTest extends TestCase
{
    private RemoteUrlRule $rule;

    protected function setUp(): void
    {
        parent::setUp();

        $this->rule = new RemoteUrlRule();
    }

    public function testPassesIPButOnlyPublicNotPrivate(): void
    {
        $matrix = [
            ['https://194.145.181.176', true],
            ['https://194.145.181.176/logo.png', true],
            ['http://0.0.0.0', false],
            ['https://0.0.0.0', false],
            ['http://0.0.0.0', false],
            ['http://127.0.0.1', false],
            ['http://192.168.0.1', false],
        ];
        $this->assertMatrix($matrix);
    }

    public function testDoamains(): void
    {
        $matrix = [
            ['git://test', false],
            ['https://azzurro.cz', true],
            ['https://www.azzurro.cz', true],
            ['https://beta-xx.azzurro.cz', true],
            ['https://beta-s.beta.azzurro.cz', true],
            ['https://beta-é.beta.azzurro.cz', false],
            ['https://redtag.studio', true],
            ['https://google.de', true],
            ['http://azzurro.cz/logo.test', true],
            ['http://google.com/image.png', true],
            ['http://localhost', false],
            ['https://localhost', false],
            ['ftp://test', false],
            ['https://redis', false],
            ['https://mariadb', false],
        ];
        $this->assertMatrix($matrix);
    }

    protected function assertMatrix(array $matrix): void
    {
        foreach ($matrix as $values) {
            [$ip, $check] = $values;
            $this->assertEquals($check, $this->rule->passes('test', $ip), 'Not valid url ' . $ip);
        }
    }
}
