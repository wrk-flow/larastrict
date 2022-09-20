<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Commands;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Testing\PendingCommand;
use LaraStrict\Testing\LaraStrictTestServiceProvider;
use LogicException;
use Mockery\MockInterface;
use Tests\LaraStrict\Feature\TestCase;
use Tests\LaraStrict\Feature\Testing\Actions\TestAction;

class MakeExpectationCommandTest extends TestCase
{
    private MockInterface $fileSystem;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fileSystem = $this->mock(Filesystem::class);
    }

    public function testWithoutAutoloadDev(): void
    {
        $expectedPath = ['tests', 'LaraStrict', 'Feature', 'Testing', 'Actions'];
        $this->expectResultFile($expectedPath, 'TestActionExpectation');

        $this->assertCommand(0, TestAction::class);
    }

    public function testWithAutoloadDevButOnlyOneEntry(): void
    {
        $expectedPath = ['app', 'tests', 'LaraStrict', 'Feature', 'Testing', 'Actions'];

        $this->expectResultFile($expectedPath, 'TestActionExpectation', 'one');

        $this->assertCommand(0, TestAction::class, 'one');
    }

    public function testWithAutoloadDevTwoEntrySelectionSecond(): void
    {
        $expectedPath = ['src', 'tests', 'Integration', 'LaraStrict', 'Feature', 'Testing', 'Actions'];

        $this->expectResultFile($expectedPath, 'TestActionExpectation', 'two');

        $this->assertCommand(0, TestAction::class, 'two', true);
    }

    public function testMissingClass(): void
    {
        $this->expectExceptionMessage('Not enough arguments (missing: "class")');
        $this->assertCommand(1, null);
    }

    public function testClassDoesNotExists(): void
    {
        $this->expectExceptionMessage('Class "Test" does not exist');
        $this->assertCommand(1, 'Test');
    }

    public function testMethodDoesNotExistsDefaultValue(): void
    {
        $this->expectExceptionMessage('Method Tests\LaraStrict\Feature\TestCase::execute() does not exist');
        $this->assertCommand(1, TestCase::class);
    }

    protected function getPackageProviders($app)
    {
        return [...parent::getPackageProviders($app), ...[LaraStrictTestServiceProvider::class]];
    }

    protected function assertCommand(
        int $expectedResult,
        ?string $class,
        ?string $variantPrefix = null,
        bool $askWhichNamespace = false
    ): void {
        if ($class !== null) {
            $this->fileSystem->shouldReceive('get')
                ->once()
                ->withArgs(
                    static fn (string $path): bool => str_contains(
                        $path,
                        '/vendor/orchestra/testbench-core/laravel/composer.json'
                    )
                )
                ->andReturnUsing(static function (string $path) use ($variantPrefix): string {
                    if ($variantPrefix !== null) {
                        $variantPrefix = __DIR__ . DIRECTORY_SEPARATOR . $variantPrefix . '.composer.json';
                    }

                    $filePath = $variantPrefix ?? $path;
                    $fileGetContents = file_get_contents($filePath);
                    if ($fileGetContents === false) {
                        throw new LogicException('File not loaded' . $filePath);
                    }

                    return $fileGetContents;
                });
        }

        $parameters = array_filter([
            'class' => $class,
        ]);

        /** @phpstan-var PendingCommand $pendingCommand */
        $pendingCommand = $this->artisan('make:expectation', $parameters);

        if ($askWhichNamespace) {
            $pendingCommand->expectsChoice('What namespace to use?', 'App\\Integration\\', [
                'Tests\\',
                'App\\Integration\\',
            ]);
        }

        if ($expectedResult === 0) {
            $pendingCommand->expectsOutputToContain('Expectation generated [');
        }

        $pendingCommand
            ->assertExitCode($expectedResult);
    }

    protected function expectResultFile(
        array $expectedBasePathParts,
        string $expectedFileName,
        ?string $variantPrefix = null
    ): void {
        $expectedPath = implode(DIRECTORY_SEPARATOR, [
            'vendor',
            'orchestra',
            'testbench-core',
            'laravel',
            ...$expectedBasePathParts,
        ]);

        $this->fileSystem->shouldReceive('ensureDirectoryExists')
            ->once()
            ->withArgs(static fn (string $path): bool => str_contains($path, $expectedPath));

        $this->fileSystem->shouldReceive('put')
            ->once()
            ->withArgs(function (string $path, string $contents) use (
                $expectedPath,
                $expectedFileName,
                $variantPrefix
            ): bool {
                $filePath = $expectedPath . DIRECTORY_SEPARATOR . $expectedFileName . '.php';
                $this->assertStringContainsString($filePath, $path);

                $stubFile = __DIR__ . DIRECTORY_SEPARATOR . ($variantPrefix ? ($variantPrefix . '.') : '') . $expectedFileName . '.php.stub';
                $expectedResult = file_get_contents($stubFile);
                $this->assertEquals($expectedResult, $contents);
                return true;
            });
    }
}
