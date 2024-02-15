<?php declare(strict_types = 1);

namespace LaraStrict\Testing\Actions;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use LaraStrict\Testing\Attributes\Expectation;
use LaraStrict\Testing\Constants\StubConstants;
use LaraStrict\Testing\Contracts\GetBasePathForAssertsActionContract;
use LaraStrict\Testing\Entities\AssertFileStateEntity;
use LaraStrict\Testing\Entities\NamespaceEntity;
use LaraStrict\Testing\Exceptions\LogicException;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\PsrPrinter;
use ReflectionClass;
use ReflectionMethod;

final class GenerateExpectationClassAction
{
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly WritePhpFileAction $writePhpFileAction,
        private readonly GenerateAssertClassAction $generateAssertClassAction,
        private readonly ParsePhpDocAction $parsePhpDocAction,
        private readonly ExpectationFileContentAction $expectationFileContentAction,
        private readonly ExpectationMethodAssertAction $expectationMethodAssertAction,
        private readonly GetBasePathForAssertsActionContract $getBasePathForAssetsAction,
    ) {}

    /**
     * @param class-string $inputClass
     * @return array{assert: string, expectations: array<string>}
     */
    public function execute(
        string $inputClass,
        NamespaceEntity $namespace,
    ): array {
        $class = new ReflectionClass($inputClass);
        $methods = self::checkInputClass($class);

        $fileNamespace = self::makeFileNamespace($class, $namespace);

        // Base namespace can contain
        $directory = $this->getBasePathForAssetsAction->execute() . DIRECTORY_SEPARATOR . $namespace->folder . strtr(
                $fileNamespace,
                StubConstants::NameSpaceSeparator,
                DIRECTORY_SEPARATOR,
            );
        $fullNamespace = $namespace->baseNamespace . $fileNamespace;

        $this->filesystem->ensureDirectoryExists($directory);

        // Generate assert file that uses generated expectation in a construct
        $assertFileState = $this->generateAssertClassAction->execute(
            class: $class,
            namespace: $fullNamespace,
        );

        $assertClassName = $assertFileState->class->getName();
        assert(is_string($assertClassName));

        $printer = new PsrPrinter();
        $expectations = [];
        foreach ($methods as $method) {
            $expectationClassName = self::makeExpectationClassName($class, $method);
            $phpDoc = $this->parsePhpDocAction->execute($method);

            $expectationContent = $this->expectationFileContentAction->execute(
                printer: $printer,
                namespace: $fullNamespace,
                className: $expectationClassName,
                method: $method,
                phpDoc: $phpDoc,
            );

            $this->expectationMethodAssertAction->execute(
                assertClass: $assertFileState->class,
                method: $method,
                expectationClassName: $expectationClassName,
                phpDoc: $phpDoc,
            );

            $expectations[] = $this->writePhpFileAction->execute($directory, $expectationClassName, $expectationContent);
            $assertFileState->expectationClasses[$method->getName()] = $expectationClassName;
        }

        $this->addAttributes($assertFileState);

        $assertFilePath = $this->writePhpFileAction->execute(
            directory: $directory,
            className: $assertClassName,
            content: $printer->printFile($assertFileState->file),
        );

        return ['assert' => $assertFilePath, 'expectations' => $expectations];
    }

    /**
     * @param ReflectionClass<object> $class
     */
    private static function makeFileNamespace(ReflectionClass $class, NamespaceEntity $namespace): string
    {
        $classNamespace = $class->getNamespaceName();
        if (str_starts_with($classNamespace, $namespace->baseNamespace) === false) {
            $namespaceParts = explode(StubConstants::NameSpaceSeparator, $classNamespace);
            array_shift($namespaceParts);

            return implode(StubConstants::NameSpaceSeparator, $namespaceParts);
        }

        return str_replace($namespace->baseNamespace, '', $classNamespace);
    }

    /**
     * @param ReflectionClass<object> $class
     * @return array<ReflectionMethod>
     */
    private static function checkInputClass(ReflectionClass $class): array
    {
        $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

        if ($methods === []) {
            throw new LogicException('Class %s does not contain any public', $class->getName());
//        } else if ($class->isInterface() === false) {
//            throw new LogicException('Class %s is not interface', $class->getName());
        }

        return $methods;
    }

    /**
     * @param ReflectionClass<object> $class
     */
    private static function makeExpectationClassName(ReflectionClass $class, ReflectionMethod $method): string
    {
        $methodSuffix = Str::ucfirst($method->getName());

        return $class->getShortName() . $methodSuffix . 'Expectation';
    }

    private function addAttributes(AssertFileStateEntity $assertFileState): void
    {
        foreach ($assertFileState->expectationClasses as $methodName => $expectationClass) {
            $assertFileState->constructor->addComment(sprintf(
                '@param array<%s|null> $%s',
                $expectationClass,
                $methodName,
            ));

            $assertFileState->constructor->addBody(sprintf(
                '$this->setExpectations(%s::class, $%s);',
                $expectationClass,
                $methodName,
            ));

            $assertFileState->constructor
                ->addParameter($methodName)
                ->setType('array')
                ->setDefaultValue(new Literal('[]'));

            $assertFileState->class->addAttribute(Expectation::class, [
                'class' => new Literal($expectationClass . '::class'),
            ]);
        }
    }

}
