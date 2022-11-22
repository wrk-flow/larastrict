<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Laravel\Contracts\Container;

use LaraStrict\Testing\AbstractExpectationCallsMap;
use LaraStrict\Testing\Concerns\AssertExpectations;
use LaraStrict\Testing\Entities\AssertExpectationEntity;
use LaraStrict\Testing\Laravel\Contracts\Container\ContainerAliasExpectation;
use LaraStrict\Testing\Laravel\Contracts\Container\ContainerAssert;
use LaraStrict\Testing\Laravel\Contracts\Container\ContainerBoundExpectation;
use LaraStrict\Testing\Laravel\Contracts\Container\ContainerTagExpectation;
use LaraStrict\Testing\Laravel\Contracts\Container\ContainerTaggedExpectation;
use PHPUnit\Framework\TestCase;

class ContainerAssertTest extends TestCase
{
    use AssertExpectations;

    protected function generateData(): array
    {
        return [
            new AssertExpectationEntity(
                methodName: 'bound',
                createAssert: fn () => new ContainerAssert(bound: [new ContainerBoundExpectation(
                    return: true,
                    abstract: 'test'
                )]),
                call: fn (ContainerAssert $assert) => $assert->bound(abstract: 'test'),
                checkResult: true,
                expectedResult: true,
            ),
            new AssertExpectationEntity(
                methodName: 'bound',
                createAssert: fn () => new ContainerAssert(bound: [new ContainerBoundExpectation(
                    return: false,
                    abstract: 'test'
                )]),
                call: fn (ContainerAssert $assert) => $assert->bound(abstract: 'test'),
                checkResult: true,
                expectedResult: false,
            ),
            new AssertExpectationEntity(
                methodName: 'alias',
                createAssert: fn () => new ContainerAssert(alias: [new ContainerAliasExpectation(
                    abstract: 'test',
                    alias: 'alias',
                )]),
                call: fn (ContainerAssert $assert) => $assert->alias(abstract: 'test', alias: 'alias'),
            ),
            new AssertExpectationEntity(
                methodName: 'tag',
                createAssert: fn () => new ContainerAssert(tag: [new ContainerTagExpectation(
                    abstracts: ['test'],
                    tags: ['tag']
                )]),
                call: fn (ContainerAssert $assert) => $assert->tag(abstracts: ['test'], tags: ['tag']),
            ),
            new AssertExpectationEntity(
                methodName: 'tagged',
                createAssert: fn () => new ContainerAssert(tagged: [new ContainerTaggedExpectation(
                    return: ['test'],
                    tag: 'tag'
                )]),
                call: fn (ContainerAssert $assert) => $assert->tagged(tag: 'tag'),
                checkResult: true,
                expectedResult: ['test'],
            ),
        ];
    }

    protected function createEmptyAssert(): AbstractExpectationCallsMap
    {
        return new ContainerAssert();
    }
}
