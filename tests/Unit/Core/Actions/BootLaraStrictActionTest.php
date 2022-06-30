<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Core\Actions;

use LaraStrict\Actions\BootLaraStrictAction;
use LaraStrict\Providers\Pipes\PreventLazyLoadingPipe;
use LaraStrict\Providers\Pipes\SetFactoryResolvingProviderPipe;
use LaraStrict\Testing\Actions\TestRunAppServiceProviderAction;
use LaraStrict\Testing\Laravel\TestingApplication;
use LaraStrict\Testing\Laravel\TestingServiceProvider;
use PHPUnit\Framework\TestCase;

class BootLaraStrictActionTest extends TestCase
{
    public function testExecute(): void
    {
        $runAction = new TestRunAppServiceProviderAction(
            expectedPipes: [PreventLazyLoadingPipe::class, SetFactoryResolvingProviderPipe::class],
            expectedServiceName: 'core',
            expectServiceRootDirToEndWith: 'src'
        );
        $bootAction = new BootLaraStrictAction($runAction);

        $app = new TestingApplication();

        $bootAction->execute($app, new TestingServiceProvider($app));
        $this->assertTrue($runAction->executed);
    }
}
