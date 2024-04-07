<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Laravel\Contracts\View;

use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use LaraStrict\Testing\Concerns\AssertExpectations;
use LaraStrict\Testing\Entities\AssertExpectationEntity;
use LaraStrict\Testing\Laravel\Contracts\View\FactoryAddNamespaceExpectation;
use LaraStrict\Testing\Laravel\Contracts\View\FactoryAssert;
use LaraStrict\Testing\Laravel\Contracts\View\FactoryComposerExpectation;
use LaraStrict\Testing\Laravel\Contracts\View\FactoryCreatorExpectation;
use LaraStrict\Testing\Laravel\Contracts\View\FactoryExistsExpectation;
use LaraStrict\Testing\Laravel\Contracts\View\FactoryFileExpectation;
use LaraStrict\Testing\Laravel\Contracts\View\FactoryMakeExpectation;
use LaraStrict\Testing\Laravel\Contracts\View\FactoryReplaceNamespaceExpectation;
use LaraStrict\Testing\Laravel\Contracts\View\FactoryShareExpectation;
use LaraStrict\Testing\Laravel\Contracts\View\ViewAssert;
use Tests\LaraStrict\Feature\TestCase;
use Tests\LaraStrict\Unit\Testing\Laravel\Composer;

class FactoryAssertTest extends TestCase
{
    use AssertExpectations;
    final public const Data = [
        'data' => 1,
    ];
    final public const MergeData = [
        'data' => 2,
    ];

    protected static function generateData(): array
    {
        $view = new ViewAssert();

        return [
            new AssertExpectationEntity(
                methodName: 'exists',
                createAssert: static fn () => new FactoryAssert(
                    exists: [new FactoryExistsExpectation(return: true, view: 'test')]
                ),
                call: static fn (FactoryAssert $assert) => $assert->exists(view: 'test'),
                checkResult: true,
                expectedResult: true
            ),
            new AssertExpectationEntity(
                methodName: 'exists',
                createAssert: static fn () => new FactoryAssert(
                    exists: [new FactoryExistsExpectation(return: false, view: 'test')]
                ),
                call: static fn (FactoryAssert $assert) => $assert->exists(view: 'test'),
                checkResult: true,
                expectedResult: false
            ),
            new AssertExpectationEntity(
                methodName: 'file',
                createAssert: static fn () => new FactoryAssert(
                    file: [new FactoryFileExpectation(
                        return: $view,
                        path: 'test',
                        data: self::Data,
                        mergeData: self::MergeData,
                    )]
                ),
                call: static fn (FactoryAssert $assert) => $assert->file(
                    path: 'test',
                    data: self::Data,
                    mergeData: self::MergeData,
                ),
                checkResult: true,
                expectedResult: $view
            ),
            new AssertExpectationEntity(
                methodName: 'make',
                createAssert: static fn () => new FactoryAssert(
                    make: [new FactoryMakeExpectation(
                        return: $view,
                        view: 'test',
                        data: self::Data,
                        mergeData: self::MergeData,
                    )]
                ),
                call: static fn (FactoryAssert $assert) => $assert->make(
                    view: 'test',
                    data: self::Data,
                    mergeData: self::MergeData,
                ),
                checkResult: true,
                expectedResult: $view
            ),
            new AssertExpectationEntity(
                methodName: 'share',
                createAssert: static fn () => new FactoryAssert(
                    share: [new FactoryShareExpectation(return: self::Data, key: 'test', value: self::Data)]
                ),
                call: static fn (FactoryAssert $assert) => $assert->share(key: 'test', value: self::Data),
                checkResult: true,
                expectedResult: self::Data
            ),
            new AssertExpectationEntity(
                methodName: 'share',
                createAssert: static fn () => new FactoryAssert(
                    share: [new FactoryShareExpectation(return: null, key: 'test')]
                ),
                call: static fn (FactoryAssert $assert) => $assert->share(key: 'test'),
                checkResult: true,
                expectedResult: null
            ),
            new AssertExpectationEntity(
                methodName: 'composer',
                createAssert: static fn () => new FactoryAssert(
                    composer: [new FactoryComposerExpectation(
                        return: self::Data,
                        views: ['view1', 'view2'],
                        callback: static fn () => ''
                    )]
                ),
                call: static fn (FactoryAssert $assert) => $assert->composer(
                    views: ['view1', 'view2'],
                    callback: static fn () => ''
                ),
                checkResult: true,
                expectedResult: self::Data
            ),
            new AssertExpectationEntity(
                methodName: 'composer',
                createAssert: static fn () => new FactoryAssert(
                    composer: [new FactoryComposerExpectation(
                        return: self::Data,
                        views: ['view1', 'view2'],
                        callback: Composer::class
                    )]
                ),
                call: static fn (FactoryAssert $assert) => $assert->composer(
                    views: ['view1', 'view2'],
                    callback: Composer::class
                ),
                checkResult: true,
                expectedResult: self::Data
            ),
            new AssertExpectationEntity(
                methodName: 'creator',
                createAssert: static fn () => new FactoryAssert(
                    creator: [new FactoryCreatorExpectation(
                        return: self::Data,
                        views: ['view1', 'view2'],
                        callback: static fn () => ''
                    )]
                ),
                call: static fn (FactoryAssert $assert) => $assert->creator(
                    views: ['view1', 'view2'],
                    callback: static fn () => ''
                ),
                checkResult: true,
                expectedResult: self::Data
            ),
            new AssertExpectationEntity(
                methodName: 'creator',
                createAssert: static fn () => new FactoryAssert(
                    creator: [new FactoryCreatorExpectation(
                        return: self::Data,
                        views: ['view1', 'view2'],
                        callback: Composer::class
                    )]
                ),
                call: static fn (FactoryAssert $assert) => $assert->creator(
                    views: ['view1', 'view2'],
                    callback: Composer::class
                ),
                checkResult: true,
                expectedResult: self::Data
            ),
            new AssertExpectationEntity(
                methodName: 'addNamespace',
                createAssert: static fn () => new FactoryAssert(
                    addNamespace: [new FactoryAddNamespaceExpectation(namespace: __NAMESPACE__, hints: ['test'])]
                ),
                call: static fn (FactoryAssert $assert) => $assert->addNamespace(
                    namespace: __NAMESPACE__,
                    hints: ['test']
                ),
                checkResult: true,
                checkResultIsSelf: true
            ),
            new AssertExpectationEntity(
                methodName: 'replaceNamespace',
                createAssert: static fn () => new FactoryAssert(
                    replaceNamespace: [new FactoryReplaceNamespaceExpectation(
                        namespace: __NAMESPACE__,
                        hints: ['test']
                    )]
                ),
                call: static fn (FactoryAssert $assert) => $assert->replaceNamespace(
                    namespace: __NAMESPACE__,
                    hints: ['test']
                ),
                checkResult: true,
                checkResultIsSelf: true
            ),
        ];
    }

    protected function createEmptyAssert(): AbstractExpectationCallsMap
    {
        return new FactoryAssert();
    }
}
