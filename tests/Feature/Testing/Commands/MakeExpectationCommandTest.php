<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Commands;

use Closure;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Testing\PendingCommand;
use LogicException;
use Mockery\MockInterface;
use PHPUnit\Framework\Attributes\DataProvider;
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
    final public const string TestFileName = 'app/TestAction.php';

    private MockInterface $fileSystem;
    private static ?bool $stubsGenerated = null;

    protected function setUp(): void
    {
        parent::setUp();

        $this->fileSystem = $this->mock(Filesystem::class);
    }

    public function generateStubsIfNeeded(string $stubFile, string $contents): void
    {
        self::$stubsGenerated ??= (bool) getenv('STUBS_GENERATE');

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
     * @param list<string> $expectationVariants
     */
    #[DataProvider('data')]
    public function testWithoutAutoloadDev(
        string $classOrFilePath,
        bool $useClass,
        string $fileName,
        bool $checkAssert = false,
        array $expectationVariants = [],
    ): void {
        $this->expectClass($useClass, $fileName);

        $expectedPath = ['tests'];
        $assertGeneratedFiles = $this->expectResultFile(
            $expectedPath,
            $fileName,
            checkAssert: $checkAssert,
            expectationVariants: $expectationVariants,
        );

        $this->assertCommand(0, $classOrFilePath);
        $assertGeneratedFiles();
    }

    /**
     * @param list<string> $expectationVariants
     */
    #[DataProvider('data')]
    public function testWithAutoloadDevButOnlyOneEntry(
        string $classOrFilePath,
        bool $useClass,
        string $fileName,
        bool $checkAssert = false,
        array $expectationVariants = [],
    ): void {
        $this->expectClass($useClass, $fileName);

        $expectedPath = ['app', 'tests'];

        $assertGeneratedFiles = $this->expectResultFile(
            $expectedPath,
            $fileName,
            'one',
            checkAssert: $checkAssert,
            expectationVariants: $expectationVariants,
        );

        $this->assertCommand(0, $classOrFilePath, 'one');
        $assertGeneratedFiles();
    }

    /**
     * @param list<string> $expectationVariants
     */
    #[DataProvider('data')]
    public function testWithAutoloadDevTwoEntrySelectionSecond(
        string $classOrFilePath,
        bool $useClass,
        string $fileName,
        bool $checkAssert = false,
        array $expectationVariants = [],
    ): void {
        $this->expectClass($useClass, $fileName);

        $expectedPath = ['src', 'tests', 'Integration'];

        $assertGeneratedFiles = $this->expectResultFile(
            $expectedPath,
            $fileName,
            'two',
            checkAssert: $checkAssert,
            expectationVariants: $expectationVariants,
        );

        $this->assertCommand(0, $classOrFilePath, 'two', true);
        $assertGeneratedFiles();
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
            expectComposerJson: false,
        );
    }

    public function testMethodDoesNotExistsDefaultValue(): void
    {
        $this->expectExceptionMessage(
            'Class Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand\NoMethods does not contain any public',
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
            expectComposerJson: false,
        );
    }

    /**
     * @return array<array-key, mixed>
     */
    public static function data(): array
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
            '/vendor/orchestra/testbench-core/laravel/' . self::TestFileName,
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
                        '/vendor/orchestra/testbench-core/laravel/composer.json',
                    ),
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

    /**
     * @param list<string> $expectationVariants
     * @param list<string> $expectedBasePathParts
     */
    protected function expectResultFile(
        array $expectedBasePathParts,
        string $expectedFileName,
        ?string $variantPrefix = null,
        bool $checkAssert = false,
        array $expectationVariants = [],
    ): Closure {
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

        /** @var array<string, string> $writtenFiles */
        $writtenFiles = [];

        $this->fileSystem->shouldReceive('put')
            ->times(count($expectationVariants))
            ->withArgs(static function (string $path, string $contents) use (&$writtenFiles): bool {
                $writtenFiles[$path] = $contents;
                return true;
            });

        if ($checkAssert) {
            $this->fileSystem->shouldReceive('put')
                ->once()
                ->withArgs(static function (string $path, string $contents) use (&$writtenFiles): bool {
                    $writtenFiles[$path] = $contents;
                    return true;
                });
        }

        return function () use (
            &$writtenFiles,
            $checkAssert,
            $expectedFileName,
            $expectedPath,
            $expectationVariants,
            $variantPrefix,
        ): void {
            $expectedFiles = $expectationVariants;
            if ($checkAssert) {
                $expectedFiles[] = $expectedFileName . 'Assert';
            }

            foreach ($expectedFiles as $expectedFile) {
                $expectedPathAndFile = $this->getExpectedPath($expectedPath, $expectedFile);
                $matchingPaths = array_filter(
                    array_keys($writtenFiles),
                    static fn (string $path): bool => str_contains($path, $expectedPathAndFile),
                );
                self::assertCount(1, $matchingPaths, 'Generated file not found: ' . $expectedPathAndFile);

                $matchingPath = array_values($matchingPaths)[0];
                $contents = $writtenFiles[$matchingPath];
                $stubFile = $this->getStubFilePath($variantPrefix, $expectedFile);
                $this->generateStubsIfNeeded($stubFile, $contents);

                $expectedResult = file_get_contents($stubFile);
                self::assertIsString($expectedResult);

                if ($expectedFile === 'MultiFunctionContractAssert') {
                    $this->assertMultiFunctionContractAssertEquals($expectedResult, $contents);
                } else {
                    self::assertSame($expectedResult, $contents);
                }

                unset($writtenFiles[$matchingPath]);
            }

            self::assertSame([], $writtenFiles, 'Unexpected generated files remain.');
        };
    }

    private function assertMultiFunctionContractAssertEquals(string $expected, string $actual): void
    {
        $normalize = static function (string $contents): array {
            // PHP versions format the generated self return type differently. Both forms describe the same contract.
            $contents = str_replace(
                [
                    ': MultiFunctionContract',
                    ': \\Tests\\LaraStrict\\Feature\\Testing\\Commands\\MakeExpectationCommand\\MultiFunctionContract',
                ],
                ': self',
                $contents,
            );

            // Compare PHP tokens so that formatter-specific whitespace does not affect the generated-code assertion.
            $tokens = array_values(array_filter(
                token_get_all($contents),
                static fn (array|string $token): bool => ! is_array($token) || $token[0] !== T_WHITESPACE,
            ));
            // PHP versions differ on whether the generated multiline parameter list keeps its trailing comma.
            $tokens = array_values(array_filter(
                $tokens,
                static fn (array|string $token, int $index): bool => $token !== ',' || ($tokens[$index + 1] ?? null) !== ')',
                ARRAY_FILTER_USE_BOTH,
            ));

            // token_get_all() includes source line numbers, which change when PHP formats the same code differently.
            return array_map(
                static fn (array|string $token): array|string => is_array($token)
                    ? [$token[0], $token[1]]
                    : $token,
                $tokens,
            );
        };

        self::assertSame($normalize($expected), $normalize($actual));
    }
}
