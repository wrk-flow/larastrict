<?php declare(strict_types=1);

namespace LaraStrict\Testing\Actions;

use Illuminate\Filesystem\Filesystem;
use LaraStrict\Testing\Contracts\FindAllClassesActionContract;
use LaraStrict\Testing\Contracts\GetBasePathForStubsActionContract;

final class InputArgumentClassToClassesAction
{
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly PathToClassByComposerAction $pathToClassAction,
        private readonly FindAllClassesActionContract $findAllClassesAction,
        private readonly GetBasePathForStubsActionContract $getBasePathAction,
    )
    {
    }


    /**
     * @param class-string|string $class
     * @return array<class-string>
     */
    public function execute(string $class): array
    {
        if ($class === 'all') {
            return $this->findAllClassesAction->execute();
        } elseif (str_ends_with($class, '.php') === false) {
            $inClass = $this->checkInterface($class);
        } else {
            $inClass = $this->normalizeToClass($class);
        }

        return $inClass === null ? [] : [$inClass];
    }


    /**
     * @return class-string
     */
    private function checkInterface(string $class): ?string
    {
        if (class_exists($class) === false && interface_exists($class) === false) {
            return null;
        }

        return $class;
    }


    /**
     * @return class-string|null
     */
    private function normalizeToClass(string $class): ?string
    {
        $fullPath = $this->getBasePathAction->execute() . DIRECTORY_SEPARATOR . $class;

        if ($this->filesystem->exists($fullPath) === false) {
            return null;
        }

        return $this->pathToClassAction->execute($fullPath);
    }
}
