<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Config\Contracts;

use LaraStrict\Enums\EnvironmentType;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use LaraStrict\Testing\Concerns\AssertExpectations;
use LaraStrict\Testing\Config\Contracts\AppConfigContractAssert;
use LaraStrict\Testing\Config\Contracts\AppConfigContractGetAssetUrlExpectation;
use LaraStrict\Testing\Config\Contracts\AppConfigContractGetEnvironmentExpectation;
use LaraStrict\Testing\Config\Contracts\AppConfigContractGetKeyExpectation;
use LaraStrict\Testing\Config\Contracts\AppConfigContractGetNameExpectation;
use LaraStrict\Testing\Config\Contracts\AppConfigContractGetUrlExpectation;
use LaraStrict\Testing\Config\Contracts\AppConfigContractGetVersionExpectation;
use LaraStrict\Testing\Config\Contracts\AppConfigContractIsInDebugModeExpectation;
use LaraStrict\Testing\Entities\AssertExpectationEntity;
use PHPUnit\Framework\TestCase;

class AppConfigContractAssertTest extends TestCase
{
    use AssertExpectations;

    public function generateData(): array
    {
        return [
            new AssertExpectationEntity(
                methodName: 'getVersion',
                createAssert: static fn () => new AppConfigContractAssert(getVersion: [
                    new AppConfigContractGetVersionExpectation(return: '1.0.0'),
                ]),
                call: static fn (AppConfigContractAssert $assert) => $assert->getVersion(),
                checkResult: true,
                expectedResult: '1.0.0',
            ),
            new AssertExpectationEntity(
                methodName: 'getKey',
                createAssert: static fn () => new AppConfigContractAssert(getKey: [
                    new AppConfigContractGetKeyExpectation(return: 'base64key'),
                ]),
                call: static fn (AppConfigContractAssert $assert) => $assert->getKey(),
                checkResult: true,
                expectedResult: 'base64key',
            ),
            new AssertExpectationEntity(
                methodName: 'getUrl',
                createAssert: static fn () => new AppConfigContractAssert(getUrl: [
                    new AppConfigContractGetUrlExpectation(return: 'url'),
                ]),
                call: static fn (AppConfigContractAssert $assert) => $assert->getUrl(),
                checkResult: true,
                expectedResult: 'url',
            ),
            new AssertExpectationEntity(
                methodName: 'getAssetUrl',
                createAssert: static fn () => new AppConfigContractAssert(getAssetUrl: [
                    new AppConfigContractGetAssetUrlExpectation(return: 'url'),
                ]),
                call: static fn (AppConfigContractAssert $assert) => $assert->getAssetUrl(),
                checkResult: true,
                expectedResult: 'url',
            ),
            new AssertExpectationEntity(
                methodName: 'getName',
                createAssert: static fn () => new AppConfigContractAssert(getName: [
                    new AppConfigContractGetNameExpectation(return: 'name'),
                ]),
                call: static fn (AppConfigContractAssert $assert) => $assert->getName(),
                checkResult: true,
                expectedResult: 'name',
            ),
            new AssertExpectationEntity(
                methodName: 'isInDebugMode',
                createAssert: static fn () => new AppConfigContractAssert(isInDebugMode: [
                    new AppConfigContractIsInDebugModeExpectation(return: true),
                ]),
                call: static fn (AppConfigContractAssert $assert) => $assert->isInDebugMode(),
                checkResult: true,
                expectedResult: true,
            ),
            new AssertExpectationEntity(
                methodName: 'isInDebugMode',
                createAssert: static fn () => new AppConfigContractAssert(isInDebugMode: [
                    new AppConfigContractIsInDebugModeExpectation(return: false),
                ]),
                call: static fn (AppConfigContractAssert $assert) => $assert->isInDebugMode(),
                checkResult: true,
                expectedResult: false,
            ),
            new AssertExpectationEntity(
                methodName: 'getEnvironment',
                createAssert: static fn () => new AppConfigContractAssert(getEnvironment: [
                    new AppConfigContractGetEnvironmentExpectation(return: EnvironmentType::Production),
                ]),
                call: static fn (AppConfigContractAssert $assert) => $assert->getEnvironment(),
                checkResult: true,
                expectedResult: EnvironmentType::Production,
            ),
            new AssertExpectationEntity(
                methodName: 'getEnvironment',
                createAssert: static fn () => new AppConfigContractAssert(getEnvironment: [
                    new AppConfigContractGetEnvironmentExpectation(return: 'test'),
                ]),
                call: static fn (AppConfigContractAssert $assert) => $assert->getEnvironment(),
                checkResult: true,
                expectedResult: 'test',
            ),
        ];
    }

    protected function createEmptyAssert(): AbstractExpectationCallsMap
    {
        return new AppConfigContractAssert();
    }
}
