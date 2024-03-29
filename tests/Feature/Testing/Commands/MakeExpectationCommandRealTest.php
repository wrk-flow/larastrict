<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Commands;

use Exception;
use Illuminate\Testing\PendingCommand;
use LaraStrict\Testing\TestServiceProvider;
use PHPUnit\Framework\ExpectationFailedException;
use Tests\LaraStrict\Feature\TestCase;
use Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\SimpleActionContract;
use Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\SimpleActionContractAssert;
use Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\SimpleActionContractExpectation;

class MakeExpectationCommandRealTest extends TestCase
{
    final public const Namespace = 'Tests\\LaraStrict\\Feature\\';

    private string $originalPath = '';

    protected function setUp(): void
    {
        parent::setUp();
        $this->app()
            ->register(TestServiceProvider::class);

        // Do not use test bench path
        $this->originalPath = $this->app()
            ->basePath();
        $path = realpath(__DIR__ . '/../../../..');
        $this->assertTrue(is_string($path));
        $this->app()
            ->setBasePath($path);
    }

    protected function tearDown(): void
    {
        $this->app()
            ->setBasePath($this->originalPath);
        parent::tearDown();
    }

    public function testGeneratedFiles(): void
    {
        /** @phpstan-var PendingCommand $pendingCommand */
        $pendingCommand = $this->artisan('make:expectation', [
            'class' => SimpleActionContract::class,
        ]);

        $pendingCommand
            ->expectsQuestion('What namespace to use?', self::Namespace)
            ->assertExitCode(0);

        $pendingCommand->execute();

        // SimpleActionContractAssert and SimpleActionContractExpectation will be generated by command
        $this->assertTrue(class_exists(SimpleActionContractExpectation::class));
        $this->assertTrue(class_exists(SimpleActionContractAssert::class));

        $hookCalled = false;
        $assert = new SimpleActionContractAssert([
            new SimpleActionContractExpectation('test', 2, false),
            new SimpleActionContractExpectation('test2', 1, true, _hook: function (
                string $first,
                int $second,
                bool $third,
                SimpleActionContractExpectation $expectation
            ) use (&$hookCalled): void {
                $hookCalled = true;
                $this->assertEquals(1, $expectation->second);
            }),
            new SimpleActionContractExpectation('test3', 5, true),
        ]);

        $assert->execute('test', 2, false);
        $this->assertFalse($hookCalled, 'Hook should not be called');
        $assert->execute('test2', 1, true);

        $this->assertTrue($hookCalled, 'Hook should be called');

        try {
            $assert->execute('test3', 1, true);
            $this->fail('Exception not raised - second value should not match.');
        } catch (ExpectationFailedException $expectationFailedException) {
            $this->assertStringContainsString(
                'Expectation for [Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\SimpleActionContractAssert@execute] failed for a n (3) call',
                $expectationFailedException->getMessage(),
                'Should contain debug message'
            );
        }

        try {
            $assert->execute('test4', 1, true);
            $this->fail('Exception not raised - missing expectation for the call!');
        } catch (Exception $exception) {
            $this->assertEquals(
                'Expectation for [Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\SimpleActionContractAssert@execute] not set for a n (4) call',
                $exception->getMessage()
            );
        }
    }

    public function testInvalidNamespace(): void
    {
        $this->expectExceptionMessage('Invalid namespace returned');
        /** @phpstan-var PendingCommand $pendingCommand */
        $pendingCommand = $this->artisan('make:expectation', [
            'class' => SimpleActionContract::class,
        ]);
        $pendingCommand->expectsQuestion('What namespace to use?', 'Tests\\LaraStrict')
            ->assertFailed();
    }

    public function testNoClassInFileFromRelativePath(): void
    {
        /** @phpstan-var PendingCommand $pendingCommand */
        $pendingCommand = $this->artisan('make:expectation', [
            'class' => 'tests/laravel_config/app.php',
        ]);
        $pendingCommand->assertFailed()
            ->expectsOutputToContain('Provided file does not contain any class [tests/laravel_config/app.php]');
    }
}
