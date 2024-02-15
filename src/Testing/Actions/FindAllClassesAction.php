<?php declare(strict_types=1);

namespace LaraStrict\Testing\Actions;

use LaraStrict\Testing\Attributes\TestAssert;
use LaraStrict\Testing\Contracts\FindAllClassesActionContract;
use LaraStrict\Testing\Contracts\FinderFactoryContract;
use ReflectionClass;

final class FindAllClassesAction implements FindAllClassesActionContract
{
    public function __construct(
        private readonly FinderFactoryContract $finderFactory,
        private readonly PathToClassByComposerAction $pathToClassAction,
    )
    {
    }


    /**
     * @return array<class-string>
     */
    public function execute(): array
    {
        $classes = [];
        foreach ($this->finderFactory->create() as $file) {
            $interface = $this->pathToClassAction->execute($file->getRealPath());
            require_once $file->getPathname();

            if (interface_exists($interface, false) === false) {
                continue;
            }

            $classReflection = new ReflectionClass($interface);
            $attributes = $classReflection->getAttributes(TestAssert::class);
            if ($attributes === []) {
                continue;
            }
            $classes[] = $interface;
        }

        return $classes;
    }
}
