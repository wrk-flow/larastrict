<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\Actions;

use Illuminate\Console\Command;
use LaraStrict\Testing\Actions\GetDevNamespaceForStubsAction;
use PHPUnit\Framework\TestCase;

class GetDevNamespaceForStubsActionTest extends TestCase
{
    public function testNamespace(): void
    {
        $result = (new GetDevNamespaceForStubsAction())->execute(new Command(), 'test');
        $this->assertEquals('src' . DIRECTORY_SEPARATOR . 'Testing' . DIRECTORY_SEPARATOR, $result->folder);
        $this->assertEquals('LaraStrict\\Testing\\', $result->baseNamespace);
    }
}
