<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Config\Laravel;

use Closure;
use Illuminate\Contracts\Config\Repository;
use Tests\LaraStrict\Feature\TestCase;

abstract class AbstractConfigTestCase extends TestCase
{
    private Repository $configRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->configRepository = $this->app()
            ->make(Repository::class);
    }

    abstract protected function getConfigName(): string;

    protected function setRepositoryValue(array $keys, mixed $value): void
    {
        $path = implode('.', [$this->getConfigName(), ...$keys]);

        $this->configRepository->set($path, $value);
    }

    protected function setRepositoryFromFile(): void
    {
        $path = __DIR__ . '/../../../laravel_config/' . $this->getConfigName() . '.php';
        $array = require realpath($path);

        $this->setRepositoryValue([], $array);
    }

    /**
     * @param mixed|Closure(mixed):bool $expectedDefaultValue You can provide closure with "match"
     * @param array<string|int, mixed|Closure(mixed):bool> $overridesExpectationMap A map of expectations. Key is a value that will be set, value is an
     *                                       expectation.
     */
    protected function assertConfigValue(
        mixed $expectedDefaultValue,
        array $keys,
        array $overridesExpectationMap,
        Closure $getValue,
    ): void {
        $this->assertGetValue($expectedDefaultValue, $getValue, '');

        $valueIndex = 0;
        foreach ($overridesExpectationMap as $overrideValue => $expectation) {
            if ($overrideValue === 'null') {
                $overrideValue = null;
            }

            $this->setRepositoryValue($keys, $overrideValue);
            $debugMessage = 'Value was set to ' . $overrideValue . ' at expectation index ' . $valueIndex;
            $this->assertGetValue($expectation, $getValue, $debugMessage);
            ++$valueIndex;
        }
    }

    private function assertGetValue(mixed $expectation, Closure $getValue, string $message): void
    {
        if (is_callable($expectation)) {
            $value = $getValue();
            $this->assertTrue($expectation($value), $message);
        } else {
            $this->assertSame($expectation, $getValue(), $message);
        }
    }
}
