<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Validation\Rules;

use Illuminate\Contracts\Validation\ValidationRule;
use LaraStrict\Validation\Rules\RemoteUrlRule;

final class RemoteUrlRuleTest extends AbstractRuleTest
{
    public function createRule(): ValidationRule
    {
        return new RemoteUrlRule();
    }

    protected function data(): array
    {
        return [
            // Domains
            new RuleExpectation('git://test', false),
            new RuleExpectation('https://azzurro.cz', true),
            new RuleExpectation('https://www.azzurro.cz', true),
            new RuleExpectation('https://beta-xx.azzurro.cz', true),
            new RuleExpectation('https://beta-s.beta.azzurro.cz', true),
            new RuleExpectation('https://beta-é.beta.azzurro.cz', false),
            new RuleExpectation('https://redtag.studio', true),
            new RuleExpectation('https://google.de', true),
            new RuleExpectation('http://azzurro.cz/logo.test', true),
            new RuleExpectation('http://google.com/image.png', true),
            new RuleExpectation('http://localhost', false),
            new RuleExpectation('https://localhost', false),
            new RuleExpectation('ftp://test', false),
            new RuleExpectation('https://redis', false),
            new RuleExpectation('https://mariadb', false),
            // Ips
            new RuleExpectation('https://194.145.181.176', true),
            new RuleExpectation('https://194.145.181.176/logo.png', true),
            new RuleExpectation('http://0.0.0.0', false),
            new RuleExpectation('https://0.0.0.0', false),
            new RuleExpectation('http://127.0.0.1', false),
            new RuleExpectation('http://192.168.0.1', false),
        ];
    }

    protected function getExpectedMessage(): string
    {
        return 'Given test is not a valid url (public IP or domain on http/s protocol)';
    }
}
