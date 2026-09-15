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
    final public const string ComposerAutoLoadDev = 'autoload-dev';
    final public const string ComposerPsr4 = 'psr-4';

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
                $baseNamespace = array_keys($autoLoad)[0];
            } else {
                $choice = $command->choice('What namespace to use?', array_keys($autoLoad));
                if (! is_string($choice)) {
                    throw new LogicException('Invalid namespace returned');
                }
                $baseNamespace = $choice;
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

    /**
     * @return array<string, mixed>
     */
    protected function getComposerJsonData(string $basePath): array
    {
        $json = json_decode($this->filesystem->get($basePath . '/composer.json'), true, 512, JSON_THROW_ON_ERROR);
        assert(is_array($json));
        $composer = [];
        foreach ($json as $key => $value) {
            if (is_string($key)) {
                $composer[$key] = $value;
            }
        }

        return $composer;
    }

    /**
     * @param array<string, mixed> $composer
     * @return array<string, string>
     */
    private function getComposerDevAutoLoad(array $composer): array
    {
        $autoloadDev = $composer[self::ComposerAutoLoadDev] ?? null;
        if (is_array($autoloadDev) && isset($autoloadDev[self::ComposerPsr4]) && is_array(
            $autoloadDev[self::ComposerPsr4],
        )) {
            $autoload = $autoloadDev[self::ComposerPsr4];
            $result = [];
            foreach ($autoload as $namespace => $folder) {
                if (is_string($namespace) && is_string($folder)) {
                    $result[$namespace] = $folder;
                }
            }

            return $result;
        }

        return [];
    }
}
