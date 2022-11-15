<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\Actions;

use Illuminate\Console\Command;
use Illuminate\Contracts\Auth\Access\Gate;
use LaraStrict\Testing\Actions\GetDevNamespaceForStubsAction;
use LaraStrict\Testing\Contracts\GetBasePathForStubsActionContract;
use PHPUnit\Framework\TestCase;

class GetDevNamespaceForStubsActionTest extends TestCase
{
    public function data(): array
    {
        return [
            [
                GetBasePathForStubsActionContract::class,
                'LaraStrict\\Testing\\',
                'src' . DIRECTORY_SEPARATOR . 'Testing' . DIRECTORY_SEPARATOR,
            ],
            [
                Gate::class,
                'LaraStrict\\Testing\\Laravel\\',
                'src' . DIRECTORY_SEPARATOR . 'Testing' . DIRECTORY_SEPARATOR . 'Laravel' . DIRECTORY_SEPARATOR,
            ],
        ];
    }

    /**
     * @dataProvider data
     */
    public function testNamespace(string $class, string $expectedBaseNamespace, string $expectedFolder): void
    {
        $result = (new GetDevNamespaceForStubsAction())->execute(new Command(), 'test', $class);
        $this->assertEquals($expectedFolder, $result->folder);
        $this->assertEquals($expectedBaseNamespace, $result->baseNamespace);
    }
}
