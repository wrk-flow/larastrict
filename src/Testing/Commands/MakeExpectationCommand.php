<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Commands;

use Illuminate\Console\Command;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Filesystem\Filesystem;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Literal;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PromotedParameter;
use Nette\PhpGenerator\PsrPrinter;
use ReflectionClass;
use ReflectionIntersectionType;
use ReflectionNamedType;
use ReflectionParameter;
use ReflectionType;
use ReflectionUnionType;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:expectation', description: 'Make expectation class for given class')]
class MakeExpectationCommand extends Command
{
    final public const NameSpaceSeparator = '\\';

    final public const ComposerAutoLoadDev = 'autoload-dev';

    final public const ComposerPsr4 = 'psr-4';

    protected $signature = 'make:expectation 
        {class} 
        {method?} 
    ';

    public function handle(Application $application, Filesystem $filesystem): void
    {
        if (class_exists(ClassType::class) === false) {
            $this->components->error('First install package that is required:');
            $this->line('composer require nette/php-generator --dev');
            return;
        }

        $basePath = $application->basePath();
        $composer = json_decode($filesystem->get($basePath . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);

        $methodName = (string) ($this->input->getArgument('method') ?? 'execute');
        /** @phpstan-var class-string $desiredClass */
        $desiredClass = (string) $this->input->getArgument('class');
        $class = new ReflectionClass($desiredClass);

        $className = $class->getShortName() . 'Expectation';
        $parameters = $class->getMethod($methodName)
            ->getParameters();

        // Ask for which namespace which to use for "tests"
        $autoLoad = $this->getComposerDevAutoLoad($composer);
        if ($autoLoad !== []) {
            if (count($autoLoad) === 1) {
                $baseNamespace = array_keys($autoLoad)[0];
            } else {
                $baseNamespace = (string) $this->choice('What namespace to use?', array_keys($autoLoad),);
            }

            $folder = $autoLoad[$baseNamespace];
        } else {
            // autoload-dev already contains directory / namespace separator - ensure that it contains too
            $folder = 'tests' . DIRECTORY_SEPARATOR;
            $baseNamespace = 'Tests' . self::NameSpaceSeparator;
        }

        // The first part of namespace should is in 99% App => app. We need to create a valid
        // namespace in tests folder, lets remove the first namespace and rebuild the correct
        // namespace and file path from it
        $namespaceParts = explode(self::NameSpaceSeparator, $class->getNamespaceName());
        array_shift($namespaceParts);
        $fileNamespace = implode(self::NameSpaceSeparator, $namespaceParts);

        // Base namespace can contain
        $directory = $basePath . DIRECTORY_SEPARATOR . $folder . strtr(
            $fileNamespace,
            self::NameSpaceSeparator,
            DIRECTORY_SEPARATOR
        );
        $fullNamespace = $baseNamespace . $fileNamespace;

        $filesystem->ensureDirectoryExists($directory);

        $fileContents = $this->getGeneratedFileContents($fullNamespace, $className, $parameters);
        $filePath = $directory . DIRECTORY_SEPARATOR . $className . '.php';
        $filesystem->put($filePath, $fileContents);

        $this->components->info('Expectation generated [' . $filePath . ']');
    }

    /**
     * @param array<ReflectionParameter> $parameters
     */
    protected function getGeneratedFileContents(string $namespace, string $className, array $parameters): string
    {
        $file = new PhpFile();
        $file->setStrictTypes();

        $namespace = $file->addNamespace($namespace);
        $class = $namespace->addClass($className);

        $constructor = $class
            ->setFinal()
            ->addMethod('__construct');

        foreach ($parameters as $parameter) {
            $constructorParameter = $constructor
                ->addPromotedParameter($parameter->name)
                ->setReadOnly();

            $this->setParameterType($parameter, $constructorParameter);
            $this->setParameterDefaultValue($parameter, $constructorParameter);
        }

        $printer = new PsrPrinter();

        return $printer->printFile($file);
    }

    protected function setParameterType(
        ReflectionParameter $parameter,
        PromotedParameter $constructorParameter
    ): void {
        $type = $parameter->getType();

        $proposedType = 'mixed';

        // TODO move to separate action and test with unit test
        if ($type instanceof ReflectionNamedType) {
            $proposedType = $type->getName();
            $constructorParameter->setNullable($type->allowsNull());
        } elseif ($type instanceof ReflectionUnionType) {
            $setNullable = true;
            $proposedType = implode(
                '|',
                array_map(
                    static function (ReflectionNamedType $type) use (&$setNullable): string {
                        $name = $type->getName();
                        if ($name === 'null') {
                            $setNullable = false;
                        }

                        return $name;
                    },
                    $type->getTypes()
                )
            );
            if ($setNullable) {
                $constructorParameter->setNullable($type->allowsNull());
            }
        } elseif ($type instanceof ReflectionIntersectionType) {
            $setNullable = true;
            $proposedType = implode(
                '&',
                array_map(
                    static function (ReflectionType $type) use (&$setNullable): ?string {
                        if ($type instanceof ReflectionNamedType) {
                            $name = $type->getName();
                            if ($name === 'null') {
                                $setNullable = false;
                            }

                            return $name;
                        }

                        return null;
                    },
                    array_filter($type->getTypes())
                )
            );

            if ($proposedType === '') {
                $proposedType = 'mixed';
            }

            if ($setNullable) {
                $constructorParameter->setNullable($type->allowsNull());
            }
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
            $constantLiteral = new Literal(self::NameSpaceSeparator . $constant);
            $constructorParameter->setDefaultValue($constantLiteral);

            return;
        }

        $defaultValue = $parameter->getDefaultValue();

        if (is_object($defaultValue)) {
            $objectLiteral = new Literal('new ' . self::NameSpaceSeparator . $defaultValue::class . '(/* unknown */)');
            $constructorParameter->setDefaultValue($objectLiteral);
        } else {
            $constructorParameter->setDefaultValue($defaultValue);
        }
    }

    private function getComposerDevAutoLoad(array $composer): array
    {
        if (isset($composer[self::ComposerAutoLoadDev])
            && isset($composer[self::ComposerAutoLoadDev][self::ComposerPsr4])) {
            return $composer[self::ComposerAutoLoadDev][self::ComposerPsr4];
        }

        return [];
    }
}
