<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Commands;

use Closure;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Testing\PendingCommand;
use LaraStrict\Testing\LaraStrictTestServiceProvider;
use LogicException;
use Mockery\MockInterface;
use Tests\LaraStrict\Feature\TestCase;
use Tests\LaraStrict\Feature\Testing\Actions\TestAction;

class MakeExpectationCommandTest extends TestCase
{
    final public const TestFileName = 'app/TestAction.php';

    private MockInterface $fileSystem;

    protected function setUp(): void
    {
        parent::setUp();
        $this->fileSystem = $this->mock(Filesystem::class);
    }

    /**
     * @dataProvider data
     */
    public function testWithoutAutoloadDev(string $classOrFilePath, bool $useFile): void
    {
        $this->expectClass($useFile);

        $expectedPath = ['tests', 'LaraStrict', 'Feature', 'Testing', 'Actions'];
        $this->expectResultFile($expectedPath, 'TestActionExpectation');

        $this->assertCommand(0, $classOrFilePath);
    }

    /**
     * @dataProvider data
     */
    public function testWithAutoloadDevButOnlyOneEntry(string $classOrFilePath, bool $useFile): void
    {
        $this->expectClass($useFile);

        $expectedPath = ['app', 'tests', 'LaraStrict', 'Feature', 'Testing', 'Actions'];

        $this->expectResultFile($expectedPath, 'TestActionExpectation', 'one');

        $this->assertCommand(0, $classOrFilePath, 'one');
    }

    /**
     * @dataProvider data
     */
    public function testWithAutoloadDevTwoEntrySelectionSecond(string $classOrFilePath, bool $useFile): void
    {
        $this->expectClass($useFile);

        $expectedPath = ['src', 'tests', 'Integration', 'LaraStrict', 'Feature', 'Testing', 'Actions'];

        $this->expectResultFile($expectedPath, 'TestActionExpectation', 'two');

        $this->assertCommand(0, $classOrFilePath, 'two', true);
    }

    public function testMissingClass(): void
    {
        $this->expectExceptionMessage('Not enough arguments (missing: "class")');
        $this->assertCommand(1, null, expectComposerJson: false);
    }

    public function testClassDoesNotExists(): void
    {
        $this->assertCommand(
            expectedResult: 1,
            class: 'Test',
            expectedMessage: 'Provided class does not exists [Test]',
            expectComposerJson: false
        );
    }

    public function testMethodDoesNotExistsDefaultValue(): void
    {
        $this->expectExceptionMessage('Method Tests\LaraStrict\Feature\TestCase::execute() does not exist');
        $this->assertCommand(expectedResult: 1, class: TestCase::class, expectComposerJson: false);
    }

    public function testClassDoesNotExistsAtPath(): void
    {
        $this->expectClassFileExists(false);

        $this->assertCommand(
            expectedResult: 1,
            class: self::TestFileName,
            expectedMessage: 'File does not exists at [' . self::TestFileName . ']',
            expectComposerJson: false
        );
    }

    protected function expectClassFileExists(bool $return): void
    {
        $this->fileSystem->shouldReceive('exists')
            ->once()
            ->withArgs($this->expectClassFileExistsArgClosure())
            ->andReturn($return);
    }

    protected function expectClassFileExistsArgClosure(): Closure
    {
        return static fn (string $path) => str_contains(
            $path,
            '/vendor/orchestra/testbench-core/laravel/' . self::TestFileName
        );
    }

    protected function expectClass(bool $useFile): void
    {
        if ($useFile) {
            $this->expectClassFileExists(true);

            $realPath = realpath(__DIR__ . '/../Actions/TestAction.php');

            if ($realPath === false) {
                throw new LogicException('Could not resolve path to TestAction.php');
            }

            $this->fileSystem->shouldReceive('get')
                ->once()
                ->withArgs($this->expectClassFileExistsArgClosure())
                ->andReturn(file_get_contents($realPath));
        }
    }

    protected function getPackageProviders($app)
    {
        return [...parent::getPackageProviders($app), ...[LaraStrictTestServiceProvider::class]];
    }

    protected function assertCommand(
        int $expectedResult,
        ?string $class,
        ?string $variantPrefix = null,
        bool $askWhichNamespace = false,
        ?string $expectedMessage = null,
        bool $expectComposerJson = true
    ): void {
        if ($expectComposerJson) {
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

        if ($expectedResult === 0 && $expectedMessage === null) {
            $expectedMessage = 'Expectation generated [';
        }

        if ($expectedMessage !== null) {
            $pendingCommand->expectsOutputToContain($expectedMessage);
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

    private function data(): array
    {
        return [
            'with class' => [TestAction::class, false],
            'with file' => [self::TestFileName, true],
        ];
    }
}
