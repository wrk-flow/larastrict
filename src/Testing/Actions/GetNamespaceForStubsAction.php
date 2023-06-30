<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Actions;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use LaraStrict\Testing\Constants\StubConstants;
use LaraStrict\Testing\Contracts\GetNamespaceForStubsActionContract;
use LaraStrict\Testing\Entities\NamespaceEntity;
use LogicException;

class GetNamespaceForStubsAction implements GetNamespaceForStubsActionContract
{
    final public const ComposerAutoLoadDev = 'autoload-dev';
    final public const ComposerPsr4 = 'psr-4';

    public function __construct(
        private readonly Filesystem $filesystem,
    ) {
    }

    public function execute(Command $command, string $basePath, string $inputClass): NamespaceEntity
    {
        // Ask for which namespace which to use for "tests"
        $composer = $this->getComposerJsonData($basePath);
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

    protected function getComposerJsonData(string $basePath): mixed
    {
        return json_decode($this->filesystem->get($basePath . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);
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
