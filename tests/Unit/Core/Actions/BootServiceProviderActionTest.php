<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Core\Actions;

use LaraStrict\Actions\BootServiceProviderAction;
use LaraStrict\Providers\Pipes\LoadRoutesProviderPipe;
use LaraStrict\Testing\Actions\TestRunAppServiceProviderAction;
use LaraStrict\Testing\Laravel\TestingApplication;
use LaraStrict\Testing\Laravel\TestingServiceProvider;
use PHPUnit\Framework\TestCase;

class BootServiceProviderActionTest extends TestCase
{
    public function testExecute(): void
    {
        $runAction = new TestRunAppServiceProviderAction(
            expectedPipes: [LoadRoutesProviderPipe::class],
            expectedServiceName: 'laravel', // taken from App\Testing\Laravel namespace
            expectServiceRootDirToEndWith: 'src/Testing/Laravel',
        );

        $bootAction = new BootServiceProviderAction($runAction);

        $app = new TestingApplication();

        $bootAction->execute($app, new TestingServiceProvider($app));

        $this->assertTrue($runAction->executed);
    }
}
