<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Commands;

use Closure;
use Exception;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Testing\PendingCommand;
use LogicException;
use Mockery\MockInterface;
use Tests\LaraStrict\Feature\TestCase;
use Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\MultiFunctionContract;
use Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\NoMethods;
use Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\TestAction;
use Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\TestActionContract;
use Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\TestReturnAction;
use Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\TestReturnActionContract;
use Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\TestReturnIntersectionAction;
use Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\TestReturnRequiredAction;
use Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\TestReturnUnionAction;
use Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\TestReturnUnionActionContract;

class MakeExpectationCommandTest extends TestCase
{
    final public const TestFileName = 'app/TestAction.php';

    private MockInterface $fileSystem;

    private static ?bool $stubsGenerated = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fileSystem = $this->mock(Filesystem::class);
    }

    public function generateStubsIfNeeded(string $stubFile, string $contents): void
    {
        if (self::$stubsGenerated === null) {
            self::$stubsGenerated = (bool) getenv('STUBS_GENERATE');
        }

        if (self::$stubsGenerated) {
            file_put_contents($stubFile, $contents);
        }
    }

    public function getExpectedPath(string $expectedPath, string $expectedFileName): string
    {
        return $expectedPath . DIRECTORY_SEPARATOR . $expectedFileName . '.php';
    }

    public function getStubFilePath(?string $variantPrefix, string $expectedFileName): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'MakeExpectationCommand' . DIRECTORY_SEPARATOR . ($variantPrefix ? ($variantPrefix . '.') : '') . $expectedFileName . '.php.stub';
    }

    /**
     * @dataProvider data
     */
    public function testWithoutAutoloadDev(
        string $classOrFilePath,
        bool $useClass,
        string $fileName,
        bool $checkAssert = false,
        array $expectationVariants = [],
    ): void {
        $this->expectClass($useClass, $fileName);

        $expectedPath = ['tests'];
        $this->expectResultFile(
            $expectedPath,
            $fileName,
            checkAssert: $checkAssert,
            expectationVariants: $expectationVariants
        );

        $this->assertCommand(0, $classOrFilePath);
    }

    /**
     * @dataProvider data
     */
    public function testWithAutoloadDevButOnlyOneEntry(
        string $classOrFilePath,
        bool $useClass,
        string $fileName,
        bool $checkAssert = false,
        array $expectationVariants = [],
    ): void {
        $this->expectClass($useClass, $fileName);

        $expectedPath = ['app', 'tests'];

        $this->expectResultFile(
            $expectedPath,
            $fileName,
            'one',
            checkAssert: $checkAssert,
            expectationVariants: $expectationVariants
        );

        $this->assertCommand(0, $classOrFilePath, 'one');
    }

    /**
     * @dataProvider data
     */
    public function testWithAutoloadDevTwoEntrySelectionSecond(
        string $classOrFilePath,
        bool $useClass,
        string $fileName,
        bool $checkAssert = false,
        array $expectationVariants = [],
    ): void {
        $this->expectClass($useClass, $fileName);

        $expectedPath = ['src', 'tests', 'Integration'];

        $this->expectResultFile(
            $expectedPath,
            $fileName,
            'two',
            checkAssert: $checkAssert,
            expectationVariants: $expectationVariants
        );

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
        $this->expectExceptionMessage(
            'Class Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\NoMethods does not contain any public'
        );
        $this->assertCommand(expectedResult: 1, class: NoMethods::class, expectComposerJson: false);
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

    public function data(): array
    {
        return [
            'with class 1' => [TestAction::class, true, 'TestAction'],
            'with contract' => [TestActionContract::class, true, 'TestActionContract', true],
            'with contract return' => [TestReturnActionContract::class, true, 'TestReturnActionContract', true],
            'with class return 1' => [TestReturnAction::class, true, 'TestReturnAction'],
            'with class return union' => [TestReturnUnionAction::class, true, 'TestReturnUnionAction'],
            'with class return union - contract' => [
                TestReturnUnionActionContract::class,
                true,
                'TestReturnUnionActionContract',
                true,
            ],
            'with class return intersection' => [
                TestReturnIntersectionAction::class,
                true,
                'TestReturnIntersectionAction',
            ],
            'with class return non nullable' => [TestReturnRequiredAction::class, true, 'TestReturnRequiredAction'],
            'with file' => [self::TestFileName, false, 'TestAction'],
            'with file contract' => [self::TestFileName, false, 'TestActionContract', true],
            'with file contract return' => [self::TestFileName, false, 'TestReturnActionContract', true],
            'with file class return 1' => [self::TestFileName, false, 'TestReturnAction'],
            'with file return union' => [self::TestFileName, false, 'TestReturnUnionAction'],
            'with file return intersection' => [self::TestFileName, false, 'TestReturnIntersectionAction'],
            'with file return non nullable' => [self::TestFileName, false, 'TestReturnRequiredAction'],
            'MultiFunctionContract' => [MultiFunctionContract::class, true, 'MultiFunctionContract', true, [
                'MultiFunctionContractMixedExpectation',
                'MultiFunctionContractNoReturnExpectation',
                'MultiFunctionContractPhpDocBoolExpectation',
                'MultiFunctionContractPhpDocFloatExpectation',
                'MultiFunctionContractPhpDocMixedExpectation',
                'MultiFunctionContractPhpDocStaticExpectation',
                'MultiFunctionContractPhpDocStringExpectation',
                'MultiFunctionContractPhpDocThisExpectation',
                'MultiFunctionContractPhpDocThisParamsExpectation',
                'MultiFunctionContractSelfExpectation',
                'MultiFunctionContractSelfViaClassExpectation',
                'MultiFunctionContractNoParamsExpectation',
            ]],
        ];
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

    protected function expectClass(bool $useClass, string $fileName = 'TestAction'): void
    {
        if ($useClass === false) {
            $this->expectClassFileExists(true);

            $realPath = realpath(__DIR__ . '/MakeExpectationCommand/' . $fileName . '.php');

            if ($realPath === false) {
                throw new LogicException('Could not resolve path to TestAction.php');
            }

            $this->fileSystem->shouldReceive('get')
                ->once()
                ->withArgs($this->expectClassFileExistsArgClosure())
                ->andReturn(file_get_contents($realPath));
        }
    }

    protected function assertCommand(
        int $expectedResult,
        ?string $class,
        ?string $variantPrefix = null,
        bool $askWhichNamespace = false,
        ?string $expectedMessage = null,
        bool $expectComposerJson = true,
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
                        $variantPrefix = __DIR__ . DIRECTORY_SEPARATOR . 'MakeExpectationCommand' . DIRECTORY_SEPARATOR . $variantPrefix . '.composer.json';
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
            $expectedMessage = 'File generated [';
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
        ?string $variantPrefix = null,
        bool $checkAssert = false,
        array $expectationVariants = [],
    ): void {
        if ($expectationVariants === []) {
            $expectationVariants = [$expectedFileName . 'Expectation'];
        }

        $expectedPath = implode(DIRECTORY_SEPARATOR, [
            'vendor',
            'orchestra',
            'testbench-core',
            'laravel',
            ...$expectedBasePathParts,
            'LaraStrict',
            'Feature',
            'Testing',
            'Commands',
            'MakeExpectationCommand',
        ]);

        $this->fileSystem->shouldReceive('ensureDirectoryExists')
            ->once()
            ->withArgs(static fn (string $path): bool => str_contains($path, $expectedPath));

        $this->fileSystem->shouldReceive('put')
            ->times(count($expectationVariants))
            ->withArgs(function (string $path, string $contents) use (
                $expectedPath,
                $variantPrefix,
                $expectationVariants
            ): bool {
                $expectedExpectationFileName = null;
                foreach ($expectationVariants as $expectationVariant) {
                    $expectedExpectationFileName = $expectationVariant;
                    $filePath = $this->getExpectedPath($expectedPath, $expectedExpectationFileName);

                    if (str_contains($path, $filePath)) {
                        break;
                    }

                    $expectedExpectationFileName = null;
                }

                if ($expectedExpectationFileName === null) {
                    throw new Exception('Unknown variant');
                }

                $stubFile = $this->getStubFilePath($variantPrefix, $expectedExpectationFileName);

                $this->generateStubsIfNeeded($stubFile, $contents);

                $expectedResult = file_get_contents($stubFile);
                $this->assertEquals($expectedResult, $contents);
                return true;
            });

        if ($checkAssert) {
            $this->fileSystem->shouldReceive('put')
                ->once()
                ->withArgs(function (string $path, string $contents) use (
                    $expectedPath,
                    $expectedFileName,
                    $variantPrefix
                ): bool {
                    $filePath = $this->getExpectedPath($expectedPath, $expectedFileName . 'Assert');
                    $this->assertStringContainsString($filePath, $path);

                    $stubFile = $this->getStubFilePath($variantPrefix, $expectedFileName . 'Assert');

                    $this->generateStubsIfNeeded($stubFile, $contents);

                    $expectedResult = file_get_contents($stubFile);
                    $this->assertEquals($expectedResult, $contents);
                    return true;
                });
        }
    }
}
