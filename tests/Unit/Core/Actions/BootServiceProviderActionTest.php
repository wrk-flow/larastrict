<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Core\Actions;

use LaraStrict\Actions\BootServiceProviderAction;
use LaraStrict\Providers\Pipes\LoadRoutesProviderPipe;
use LaraStrict\Testing\Actions\TestRunAppServiceProviderAction;
use LaraStrict\Testing\Laravel\TestingApplication;
use PHPUnit\Framework\TestCase;
use Tests\LaraStrict\App\Providers\TestingServiceProvider;

class BootServiceProviderActionTest extends TestCase
{
    public function testExecute(): void
    {
        $runAction = new TestRunAppServiceProviderAction(
            expectedPipes: [LoadRoutesProviderPipe::class],
            expectedServiceName: 'providers', // taken from App\Testing namespace
            expectServiceRootDirToEndWith: 'tests/App/Providers',
        );

        $bootAction = new BootServiceProviderAction($runAction);

        $app = new TestingApplication();

        $bootAction->execute($app, new TestingServiceProvider($app));

        $this->assertTrue($runAction->executed);
    }
}
