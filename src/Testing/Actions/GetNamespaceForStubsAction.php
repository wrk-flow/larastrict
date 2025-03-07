<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Actions;

use Illuminate\Console\Command;
use LaraStrict\Testing\Constants\ComposerConstants;
use LaraStrict\Testing\Constants\StubConstants;
use LaraStrict\Testing\Contracts\GetBasePathForStubsActionContract;
use LaraStrict\Testing\Contracts\GetNamespaceForStubsActionContract;
use LaraStrict\Testing\Entities\NamespaceEntity;
use LaraStrict\Testing\Services\ComposerJsonDataService;
use LogicException;

class GetNamespaceForStubsAction implements GetNamespaceForStubsActionContract
{
    public function __construct(
        private readonly ComposerJsonDataService $getComposerJsonDataAction,
        private readonly GetBasePathForStubsActionContract $getBasePathAction,
    ) {
    }

    public function execute(Command $command, string $inputClass): NamespaceEntity
    {
        $basePath = $this->getBasePathAction->execute();
        // Ask for which namespace which to use for "tests"
        $composer = $this->getComposerJsonDataAction->data($basePath);
        $autoLoad = $this->getComposerDevAutoLoad($composer);
        if ($autoLoad !== []) {
            if (count($autoLoad) === 1) {
                $baseNamespace = (string) array_keys($autoLoad)[0];
            } else {
                $baseNamespace = (string) $command->choice('What namespace to use?', array_keys($autoLoad));
            }

            if (array_key_exists($baseNamespace, $autoLoad) === false) {
                throw new LogicException('Invalid namespace returned');
            }

            $folder = $autoLoad[$baseNamespace];
        } else {
            // autoload-dev already contains directory / namespace separator - ensure that it contains too
            $folder = 'tests' . DIRECTORY_SEPARATOR;
            $baseNamespace = 'Tests' . StubConstants::NameSpaceSeparator;
        }

        return new NamespaceEntity($folder, $baseNamespace);
    }

    private function getComposerDevAutoLoad(array $composer): array
    {
        if (isset($composer[ComposerConstants::AutoLoadDev][ComposerConstants::Psr4])) {
            return $composer[ComposerConstants::AutoLoadDev][ComposerConstants::Psr4];
        }

        return [];
    }
}
