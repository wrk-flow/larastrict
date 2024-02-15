<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Commands;

use Illuminate\Console\Command;
use LaraStrict\Testing\Actions\GenerateExpectationClassAction;
use LaraStrict\Testing\Actions\InputArgumentClassToClassesAction;
use LaraStrict\Testing\Contracts\GetNamespaceForStubsActionContract;
use Nette\PhpGenerator\ClassType;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'make:expectation', description: 'Make expectation class for given class')]
class MakeExpectationCommand extends Command
{
    protected $signature = 'make:expectation
        {class : Class name of path to class using PSR-4 specs or use all keyword}
    ';


    public function handle(
        GetNamespaceForStubsActionContract $getFolderAndNamespaceForStubsAction,
        GenerateExpectationClassAction $generateExpectationClassAction,
        InputArgumentClassToClassesAction $inputArgumentClassToClassesAction,
    ): int
    {
        if (class_exists(ClassType::class) === false) {
            $message = 'First install package that is required:';

            $this->writeError($message);

            $this->line('       composer require nette/php-generator "^v4.0.3" --dev');
            $this->newLine();
            return 1;
        }

        /** @var class-string|string $class */
        $class = (string) $this->input->getArgument('class');
        $inputClasses = $inputArgumentClassToClassesAction->execute($class);

        if ($inputClasses === []) {
            $this->writeError(sprintf('File or class does not exists at [%s]', $class));
            return 1;
        }

        foreach ($inputClasses as $inputClass) {
            // Ask for which namespace which to use for "tests"
            $namespace = $getFolderAndNamespaceForStubsAction->execute($this, $inputClass);

            [
                'assert' => $assertFile,
                'expectations' => $expectations,
            ] = $generateExpectationClassAction->execute(
                $inputClass,
                $namespace,
            );

            foreach ($expectations as $expectation) {
                $this->writeFile($expectation);
            }
            $this->writeFile($assertFile);
        }

        return 0;
    }


    private function writeError(string $message): void
    {
        if (property_exists($this, 'components')) {
            $this->components->error($message);
        } else {
            $this->error('ERROR:');
            $this->line($message);
        }
    }


    private function writeFile(string $filePath): void
    {
        $className = basename($filePath, '.php');
        $successMessage = 'File generated [' . $className . ']';
        if (property_exists($this, 'components')) {
            $this->components->info($successMessage);
        } else {
            $this->info($successMessage);
        }

        $this->line(sprintf('  <fg=gray>File written to [%s]</>', $filePath));
        $this->newLine();
    }

}
