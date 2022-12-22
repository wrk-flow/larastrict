<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Laravel\Contracts\View;

use LaraStrict\Testing\AbstractExpectationCallsMap;
use LaraStrict\Testing\Concerns\AssertExpectations;
use LaraStrict\Testing\Entities\AssertExpectationEntity;
use LaraStrict\Testing\Laravel\Contracts\View\ViewAssert;
use LaraStrict\Testing\Laravel\Contracts\View\ViewGetDataExpectation;
use LaraStrict\Testing\Laravel\Contracts\View\ViewNameExpectation;
use LaraStrict\Testing\Laravel\Contracts\View\ViewRenderExpectation;
use LaraStrict\Testing\Laravel\Contracts\View\ViewWithExpectation;
use PHPUnit\Framework\TestCase;

class ViewAssertTest extends TestCase
{
    use AssertExpectations;

    final public const Data = [
        'data' => 1,
    ];

    final public const MergeData = [
        'data' => 2,
    ];

    protected function generateData(): array
    {
        return [
            new AssertExpectationEntity(
                methodName: 'name',
                createAssert: static fn () => new ViewAssert(name: [new ViewNameExpectation(return: 'test')]),
                call: static fn (ViewAssert $assert) => $assert->name(),
                checkResult: true,
                expectedResult: 'test'
            ),
            new AssertExpectationEntity(
                methodName: 'with',
                createAssert: static fn () => new ViewAssert(with: [new ViewWithExpectation(key: 'test')]),
                call: static fn (ViewAssert $assert) => $assert->with(key: 'test'),
                checkResult: true,
                checkResultIsSelf: true
            ),
            new AssertExpectationEntity(
                methodName: 'with',
                createAssert: static fn () => new ViewAssert(
                    with: [new ViewWithExpectation(key: 'test', value: 'value')]
                ),
                call: static fn (ViewAssert $assert) => $assert->with(key: 'test', value: 'value'),
                checkResult: true,
                checkResultIsSelf: true
            ),
            new AssertExpectationEntity(
                methodName: 'getData',
                createAssert: static fn () => new ViewAssert(getData: [new ViewGetDataExpectation(return: 'test')]),
                call: static fn (ViewAssert $assert) => $assert->getData(),
                checkResult: true,
                expectedResult: 'test'
            ),
            new AssertExpectationEntity(
                methodName: 'render',
                createAssert: static fn () => new ViewAssert(render: [new ViewRenderExpectation(return: 'render')]),
                call: static fn (ViewAssert $assert) => $assert->render(),
                checkResult: true,
                expectedResult: 'render'
            ),
        ];
    }

    protected function createEmptyAssert(): AbstractExpectationCallsMap
    {
        return new ViewAssert();
    }
}
