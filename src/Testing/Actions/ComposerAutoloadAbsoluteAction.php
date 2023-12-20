<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Actions;

use Exception;
use Illuminate\Filesystem\Filesystem;
use LaraStrict\Testing\Contracts\GetBasePathForStubsActionContract;
use LaraStrict\Testing\Services\ComposerJsonDataService;

final class ComposerAutoloadAbsoluteAction
{
    /**
     * @var array<string, string>
     */
    private array $dirs = [];

    public function __construct(
        private readonly ComposerJsonDataService $getComposerJsonDataAction,
        private readonly Filesystem $filesystem,
        GetBasePathForStubsActionContract $getBasePathForStubsAction,
    ) {
        $this->dirs = $this->makeDirs($getBasePathForStubsAction->execute());
    }

    /**
     * @return array<string, string>
     */
    public function execute(?string $path = null): array
    {
        if ($path !== null) {
            $this->dirs += $this->loadNewComposer($path);
        }

        return $this->dirs;
    }

    /**
     * @return array<string, string>
     */
    private function makeDirs(string $basePath): array
    {
        $data = $this->getComposerJsonDataAction->data($basePath);
        $dirs = [];

        if (isset($data['autoload']['psr-4']) && is_array($data['autoload']['psr-4'])) {
            foreach ($data['autoload']['psr-4'] as $ns => $path) {
                $dirs[$ns] = $basePath . DIRECTORY_SEPARATOR . trim((string) $path, '\\/');
            }
        }

        return $dirs;
    }

    /**
     * @return array<string>
     */
    private function loadNewComposer(string $path): array
    {
        if ($this->filesystem->isFile($path)) {
            $path = $this->filesystem->dirname($path);
        } elseif ($this->filesystem->isDirectory($path) === false) {
            throw new Exception(sprintf('The path is not dir "%s".', $path));
        }

        while ($this->getComposerJsonDataAction->isExist($path) === false) {
            $path = $this->filesystem->dirname($path);
        }

        return $this->makeDirs($path);
    }
}
