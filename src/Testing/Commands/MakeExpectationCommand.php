<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use LaraStrict\Testing\Actions\ParsePhpDocAction;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use LaraStrict\Testing\Constants\StubConstants;
use LaraStrict\Testing\Contracts\GetBasePathForStubsActionContract;
use LaraStrict\Testing\Contracts\GetNamespaceForStubsActionContract;
use LaraStrict\Testing\Entities\AssertFileStateEntity;
use LaraStrict\Testing\Entities\PhpDocEntity;
use LaraStrict\Testing\Enums\PhpType;
use LogicException;
use Nette\PhpGenerator\ClassLike;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Factory;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PromotedParameter;
use Nette\PhpGenerator\PsrPrinter;
use PHPUnit\Framework\Assert;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionType;
use ReflectionUnionType;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:expectation', description: 'Make expectation class for given class')]
class MakeExpectationCommand extends Command
{
    private const HookProperty = '_hook';

    protected $signature = 'make:expectation
        {class : Class name of path to class using PSR-4 specs}
    ';

    public function handle(
        Filesystem $filesystem,
        GetBasePathForStubsActionContract $getBasePathAction,
        GetNamespaceForStubsActionContract $getFolderAndNamespaceForStubsAction,
        ParsePhpDocAction $parsePhpDocAction,
    ): int {
        if (class_exists(ClassType::class) === false) {
            $message = 'First install package that is required:';

            $this->writeError($message);

            $this->line('       composer require nette/php-generator "^v4.0.3" --dev');
            $this->newLine();
            return 1;
        }

        $basePath = $getBasePathAction->execute();

        $inputClass = $this->getInputClass($basePath, $filesystem);

        if ($inputClass === null) {
            return 1;
        }

        $class = new ReflectionClass($inputClass);

        $methods = $class->getMethods(ReflectionMethod::IS_PUBLIC);

        if ($methods === []) {
            throw new LogicException(sprintf('Class %s does not contain any public', $inputClass));
        }

        // Ask for which namespace which to use for "tests"
        $namespace = $getFolderAndNamespaceForStubsAction->execute($this, $basePath, $inputClass);

        // 1. The first part of namespace should is in 99% App => app. We need to create a valid
        // namespace in tests folder, lets remove the first namespace and rebuild the correct
        // namespace and file path from it.
        // 2. We can get a class within same namespace as a "tests/app" namespace, just remove the base namespace
        // to rebuild it later on
        $classNamespace = $class->getNamespaceName();
        if (str_starts_with($classNamespace, $namespace->baseNamespace) === false) {
            $namespaceParts = explode(StubConstants::NameSpaceSeparator, $classNamespace);
            array_shift($namespaceParts);
            $fileNamespace = implode(StubConstants::NameSpaceSeparator, $namespaceParts);
        } else {
            $fileNamespace = str_replace($namespace->baseNamespace, '', $classNamespace);
        }

        // Base namespace can contain
        $directory = $basePath . DIRECTORY_SEPARATOR . $namespace->folder . strtr(
            $fileNamespace,
            StubConstants::NameSpaceSeparator,
            DIRECTORY_SEPARATOR
        );
        $fullNamespace = $namespace->baseNamespace . $fileNamespace;

        $filesystem->ensureDirectoryExists($directory);

        $useSingleMethodCallMap = count($methods) === 1;

        // Generate assert file that uses generated expectation in a construct
        $assertClassName = $class->getShortName() . 'Assert';
        $assertFileState = $this->createAssertFileAndClass(
            class: $class,
            namespace: $fullNamespace,
            className: $assertClassName,
        );

        $printer = new PsrPrinter();

        foreach ($methods as $method) {
            $methodSuffix = $useSingleMethodCallMap ? '' : Str::ucfirst($method->getName());
            $expectationClassName = $this->getExpectationClassName($class, $methodSuffix);

            $phpDoc = $parsePhpDocAction->execute($method);

            $this->writeFile(
                directory: $directory,
                className: $expectationClassName,
                filesystem: $filesystem,
                fileContents: $this->getExpectationFileContents(
                    printer: $printer,
                    namespace: $fullNamespace,
                    className: $expectationClassName,
                    method: $method,
                    phpDoc: $phpDoc,
                ),
            );

            if ($assertFileState !== null) {
                $methodName = $method->getName();

                $assertFileState->constructorComments[] = sprintf(
                    '@param array<%s|null> $%s',
                    $expectationClassName,
                    $methodName
                );
                $assertFileState->constructorBodies[] = sprintf(
                    '$this->setExpectations(%s::class, $%s);',
                    $expectationClassName,
                    $methodName
                );

                $assertFileState
                    ->constructor
                    ->addParameter($methodName)
                    ->setType('array')
                    ->setDefaultValue(new Literal('[]'));

                $this->generateExpectationMethodAssert(
                    assertClass: $assertFileState->class,
                    method: $method,
                    expectationClassName: $expectationClassName,
                    phpDoc: $phpDoc,
                );
            }
        }

        if ($assertFileState !== null) {
            if ($assertFileState->constructor !== null) {
                $assertFileState->constructor->addComment(implode(PHP_EOL, $assertFileState->constructorComments));
                $assertFileState->constructor->addBody(implode(PHP_EOL, $assertFileState->constructorBodies));
            }

            $this->writeFile(
                directory: $directory,
                className: $assertClassName,
                filesystem: $filesystem,
                fileContents: $printer->printFile($assertFileState->file)
            );
        }

        return 0;
    }

    /**
     * Generates a method assert in assert class. Generates __construct if $expectationClassName is passed (requires
     * extending AbstractExpectationCallsMap).
     */
    protected function generateExpectationMethodAssert(
        ClassType $assertClass,
        ReflectionMethod $method,
        string $expectationClassName,
        PhpDocEntity $phpDoc,
    ): void {
        $parameters = $method->getParameters();

        $assertMethod = (new Factory())->fromMethodReflection($method);
        $assertClass->addMember($assertMethod);

        $assertMethod->addBody(sprintf(
            '$_expectation = $this->getExpectation(%s);',
            $expectationClassName . '::class'
        ));

        $hookParameters = [];

        if ($parameters !== []) {
            $assertMethod->addBody('$_message = $this->getDebugMessage();');
            $assertMethod->addBody('');

            foreach ($parameters as $parameter) {
                $hookParameters[] = sprintf('$%s', $parameter->name);
                $assertMethod->addBody(sprintf(
                    'Assert::assertEquals($_expectation->%s, $%s, $_message);',
                    $parameter->name,
                    $parameter->name
                ));
            }
        }

        $hookParameters[] = '$_expectation';

        $assertMethod->addBody('');

        $assertMethod->addBody(sprintf('if (is_callable($_expectation->%s)) {', self::HookProperty));
        $assertMethod->addBody(sprintf(
            '    call_user_func($_expectation->%s, %s);',
            self::HookProperty,
            implode(', ', $hookParameters),
        ));
        $assertMethod->addBody('}');

        $returnType = $method->getReturnType();

        if ($returnType instanceof ReflectionNamedType) {
            $enumReturnType = PhpType::tryFrom($returnType->getName()) ?? PhpType::Mixed;
        } elseif ($returnType instanceof ReflectionUnionType) {
            $enumReturnType = PhpType::Mixed;
        } else {
            $enumReturnType = $phpDoc->returnType;
        }

        switch ($enumReturnType) {
            case PhpType::Mixed:
                $assertMethod->addBody('');
                $assertMethod->addBody('return $_expectation->return;');
                break;
            case PhpType::Self:
            case PhpType::Static:
                $assertMethod->addBody('');
                $assertMethod->addBody('return $this;');
                break;
        }
    }

    /**
     * @param ReflectionClass<object> $class
     */
    protected function createAssertFileAndClass(
        ReflectionClass $class,
        string $namespace,
        string $className,
    ): ?AssertFileStateEntity {
        if ($class->isInterface() === false) {
            return null;
        }

        $file = new PhpFile();
        $file->setStrictTypes();

        $assertNamespace = $file->addNamespace($namespace);
        $assertNamespace->addUse(Assert::class);

        $assertClass = $assertNamespace->addClass($className);
        $assertClass->addImplement($class->getName());

        $assertConstructor = new Method('__construct');
        $assertClass->setExtends(AbstractExpectationCallsMap::class);
        $assertClass->addMember($assertConstructor);

        $assertConstructor->addBody('parent::__construct();');

        return new AssertFileStateEntity($file, $assertClass, $assertConstructor);
    }

    protected function getExpectationFileContents(
        PsrPrinter $printer,
        string $namespace,
        string $className,
        ReflectionMethod $method,
        PhpDocEntity $phpDoc,
    ): string {
        $parameters = $method->getParameters();

        $file = new PhpFile();
        $file->setStrictTypes();

        $class = $file
            ->addNamespace($namespace)
            ->addClass($className);

        $constructor = $class
            ->setFinal()
            ->addMethod('__construct');

        $returnType = $method->getReturnType();
        if ($returnType !== null &&
            ($returnType instanceof ReflectionNamedType === false || $this->canReturnExpectation($returnType)) ||
            $phpDoc->returnType === PhpType::Mixed) {
            $constructorParameter = $constructor
                ->addPromotedParameter('return')
                ->setReadOnly();

            $this->setParameterType($returnType, $constructorParameter);
        }

        $parameterTypes = [];
        foreach ($parameters as $parameter) {
            $constructorParameter = $constructor
                ->addPromotedParameter($parameter->name)
                ->setReadOnly();

            $parameterTypes[] = $this->setParameterType($parameter->getType(), $constructorParameter);
            $this->setParameterDefaultValue($parameter, $constructorParameter);
        }

        $constructor
            ->addPromotedParameter(self::HookProperty)
            ->setReadOnly()
            ->setType('\Closure')
            ->setNullable()
            ->setDefaultValue(null);

        $parameterTypes[] = 'self';

        $constructor->addComment(
            sprintf('@param \Closure(%s):void|null $%s', implode(',', $parameterTypes), self::HookProperty)
        );

        return $printer->printFile($file);
    }

    protected function setParameterType(
        ReflectionType|ReflectionNamedType|ReflectionUnionType|ReflectionIntersectionType|null $type,
        PromotedParameter $constructorParameter
    ): string {
        $proposedType = '';

        $allowNull = false;
        $mapToName = static function (ReflectionType $type) use (&$allowNull): ?string {
            if ($type instanceof ReflectionNamedType) {
                $name = $type->getName();
                if ($name === 'null') {
                    $allowNull = false;
                }

                // Fix global namespace
                if (class_exists($name)) {
                    return '\\' . $name;
                }

                return $name;
            }

            return null;
        };

        // TODO move to separate action and test with unit test
        if ($type instanceof ReflectionNamedType) {
            $allowNull = $type->allowsNull();
            $proposedType = $type->getName();

            if (class_exists($proposedType)) {
                // Fix global namespace
                $proposedType = '\\' . $proposedType;
            }

            $constructorParameter->setNullable($type->allowsNull());
        } elseif ($type instanceof ReflectionUnionType) {
            $allowNull = $type->allowsNull();
            $proposedType = implode('|', array_filter(array_map($mapToName, $type->getTypes())));
        } elseif ($type instanceof ReflectionIntersectionType) {
            $allowNull = $type->allowsNull();
            $proposedType = implode('&', array_filter(array_map($mapToName, $type->getTypes())));
        }

        if ($proposedType === '') {
            $proposedType = 'mixed';
        }

        if ($allowNull) {
            $constructorParameter->setNullable($allowNull);
        }

        // Callable not supported in property
        if ($proposedType === 'callable') {
            $proposedType = '\Closure';
        }

        $constructorParameter->setType($proposedType);

        return $proposedType;
    }

    protected function setParameterDefaultValue(
        ReflectionParameter $parameter,
        PromotedParameter $constructorParameter
    ): void {
        if ($parameter->isDefaultValueAvailable() === false) {
            return;
        }

        if ($parameter->isDefaultValueConstant()) {
            $constant = $parameter->getDefaultValueConstantName();
            // Ensure that constants are from global scope
            $constantLiteral = new Literal(StubConstants::NameSpaceSeparator . $constant);
            $constructorParameter->setDefaultValue($constantLiteral);

            return;
        }

        $defaultValue = $parameter->getDefaultValue();

        if (is_object($defaultValue)) {
            $objectLiteral = new Literal(
                'new ' . StubConstants::NameSpaceSeparator . $defaultValue::class . '(/* unknown */)'
            );
            $constructorParameter->setDefaultValue($objectLiteral);
        } else {
            $constructorParameter->setDefaultValue($defaultValue);
        }
    }

    protected function writeError(string $message): void
    {
        if (property_exists($this, 'components')) {
            $this->components->error($message);
        } else {
            $this->error('ERROR:');
            $this->line($message);
        }
    }

    protected function writeFile(
        string $directory,
        string $className,
        Filesystem $filesystem,
        string $fileContents
    ): void {
        $filePath = $directory . DIRECTORY_SEPARATOR . $className . '.php';
        $filesystem->put($filePath, $fileContents);

        $successMessage = 'File generated [' . $className . ']';
        if (property_exists($this, 'components')) {
            $this->components->info($successMessage);
        } else {
            $this->info($successMessage);
        }

        $this->line(sprintf('  <fg=gray>File written to [%s]</>', $filePath));
        $this->newLine();
    }

    /**
     * @param ReflectionClass<object> $class
     */
    protected function getExpectationClassName(ReflectionClass $class, string $methodSuffix): string
    {
        return $class->getShortName() . $methodSuffix . 'Expectation';
    }

    protected function canReturnExpectation(ReflectionNamedType $returnType): bool
    {
        return $returnType->getName() !== PhpType::Void
            ->value
            && $returnType->getName() !== PhpType::Self
                ->value
            && $returnType->getName() !== PhpType::Static
                ->value;
    }

    /**
     * @return class-string|null
     */
    private function getInputClass(string $basePath, Filesystem $filesystem): ?string
    {
        /** @phpstan-var class-string|string $class */
        $class = (string) $this->input->getArgument('class');

        if (str_ends_with($class, '.php')) {
            $fullPath = $basePath . '/' . $class;

            if ($filesystem->exists($fullPath) === false) {
                $this->writeError(sprintf('File does not exists at [%s]', $class));
                return null;
            }

            $file = PhpFile::fromCode($filesystem->get($fullPath));

            /** @phpstan-var array<class-string, ClassLike> $classes */
            $classes = $file->getClasses();
            if ($classes === []) {
                $this->writeError(sprintf('Provided file does not contain any class [%s]', $class));
                return null;
            }

            $class = array_keys($classes)[0];
        }

        if (class_exists($class) === false && interface_exists($class) === false) {
            $this->writeError(sprintf('Provided class does not exists [%s]', $class));
            return null;
        }

        return $class;
    }
}
