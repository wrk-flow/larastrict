<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use LaraStrict\Testing\AbstractExpectationCallMap;
use LaraStrict\Testing\Constants\StubConstants;
use LaraStrict\Testing\Contracts\GetBasePathForStubsActionContract;
use LaraStrict\Testing\Contracts\GetNamespaceForStubsActionContract;
use Nette\PhpGenerator\ClassLike;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Factory;
use Nette\PhpGenerator\Literal;
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
    protected $signature = 'make:expectation 
        {class : Class name of path to class using PSR-4 specs} 
        {method?} 
    ';

    public function handle(
        Filesystem $filesystem,
        GetBasePathForStubsActionContract $getBasePathAction,
        GetNamespaceForStubsActionContract $getFolderAndNamespaceForStubsAction,
    ): int {
        if (class_exists(ClassType::class) === false) {
            $message = 'First install package that is required:';

            $this->writeError($message);

            $this->line('       composer require nette/php-generator "^v4.0.3" --dev');
            $this->newLine();
            return 1;
        }

        $basePath = $getBasePathAction->execute();

        $methodName = (string) ($this->input->getArgument('method') ?? 'execute');

        $inputClass = $this->getInputClass($basePath, $filesystem);

        if ($inputClass === null) {
            return 1;
        }

        $class = new ReflectionClass($inputClass);

        $method = $class->getMethod($methodName);

        // Ask for which namespace which to use for "tests"
        $namespace = $getFolderAndNamespaceForStubsAction->execute($this, $basePath);

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

        $expectationClassName = $class->getShortName() . 'Expectation';

        $printer = new PsrPrinter();

        $this->writeFile(
            $directory,
            $expectationClassName,
            $filesystem,
            $this->getExpectationFileContents($printer, $fullNamespace, $expectationClassName, $method)
        );

        if ($class->isInterface()) {
            $assertClassName = $class->getShortName() . 'Assert';

            $this->writeFile(
                $directory,
                $assertClassName,
                $filesystem,
                $this->getAssertFileContents(
                    $printer,
                    $class,
                    $fullNamespace,
                    $assertClassName,
                    $method,
                    $expectationClassName
                )
            );
        }

        return 0;
    }

    /**
     * @param ReflectionClass<object> $interface
     */
    protected function getAssertFileContents(
        PsrPrinter $printer,
        ReflectionClass $interface,
        string $namespace,
        string $className,
        ReflectionMethod $method,
        string $expectationClassName,
    ): string {
        $parameters = $method->getParameters();

        $file = new PhpFile();
        $file->setStrictTypes();

        $assertNamespace = $file->addNamespace($namespace);
        $assertNamespace->addUse(Assert::class);

        $assertClass = $assertNamespace->addClass($className);

        $assertClass->setExtends(AbstractExpectationCallMap::class);
        $assertClass->addImplement($interface->getName());
        $assertClass->addComment(sprintf(
            '@extends %s<%s>',
            StubConstants::NameSpaceSeparator . AbstractExpectationCallMap::class,
            StubConstants::NameSpaceSeparator . $namespace . StubConstants::NameSpaceSeparator . $expectationClassName
        ));

        // TODO at this moment there is a bug https://github.com/nette/php-generator/pull/117/files
        // TODO it will incorrectly generate new statements
        $assertMethod = (new Factory())->fromMethodReflection($method);
        $assertClass->addMember($assertMethod);

        $assertMethod->addBody('$expectation = $this->getExpectation();');
        $assertMethod->addBody('$message = $this->getDebugMessage();');
        $assertMethod->addBody('');

        foreach ($parameters as $parameter) {
            $assertMethod->addBody(sprintf(
                'Assert::assertEquals($expectation->%s, $%s, $message);',
                $parameter->name,
                $parameter->name
            ));
        }

        $returnType = $method->getReturnType();
        if ($returnType !== null && ($returnType instanceof ReflectionNamedType === false || $returnType->getName() !== 'void')) {
            $assertMethod->addBody('');
            $assertMethod->addBody('return $expectation->return;');
        }

        return $printer->printFile($file);
    }

    protected function getExpectationFileContents(
        PsrPrinter $printer,
        string $namespace,
        string $className,
        ReflectionMethod $method,
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
        if ($returnType !== null && ($returnType instanceof ReflectionNamedType === false || $returnType->getName() !== 'void')) {
            $constructorParameter = $constructor
                ->addPromotedParameter('return')
                ->setReadOnly();

            $this->setParameterType($returnType, $constructorParameter);
        }

        foreach ($parameters as $parameter) {
            $constructorParameter = $constructor
                ->addPromotedParameter($parameter->name)
                ->setReadOnly();

            $this->setParameterType($parameter->getType(), $constructorParameter);
            $this->setParameterDefaultValue($parameter, $constructorParameter);
        }

        return $printer->printFile($file);
    }

    protected function setParameterType(
        ReflectionType|ReflectionNamedType|ReflectionUnionType|ReflectionIntersectionType|null $type,
        PromotedParameter $constructorParameter
    ): void {
        $proposedType = '';

        $allowNull = false;
        $mapToName = static function (ReflectionType $type) use (&$allowNull): ?string {
            if ($type instanceof ReflectionNamedType) {
                $name = $type->getName();
                if ($name === 'null') {
                    $allowNull = false;
                }

                return $name;
            }

            return null;
        };

        // TODO move to separate action and test with unit test
        if ($type instanceof ReflectionNamedType) {
            $allowNull = $type->allowsNull();
            $proposedType = $type->getName();
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

        $constructorParameter->setType($proposedType);
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

        $this->line(sprintf('  <fg=gray>File writen to [%s]</>', $filePath));
        $this->newLine();
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
