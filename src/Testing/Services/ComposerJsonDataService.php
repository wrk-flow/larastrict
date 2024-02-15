<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Services;

use Illuminate\Filesystem\Filesystem;
use LaraStrict\Cache\Contracts\CacheMeServiceContract;
use LaraStrict\Cache\Enums\CacheMeStrategy;
use RuntimeException;

final class ComposerJsonDataService
{
    public function __construct(
        private readonly Filesystem $filesystem,
        private readonly CacheMeServiceContract $cacheMeServiceContract,
    ) {
    }

    public function isExist(string $basePath): bool
    {
        return $this->filesystem->isFile(self::composerJson($basePath));
    }

    public function data(string $basePath): mixed
    {
        $path = realpath($basePath);
        if ($path === false) {
            throw new RuntimeException(sprintf('File does not exists %s.', $basePath));
        }
        return $this->cacheMeServiceContract->get(
            key: sprintf('larasctrict.composer.%s', $path),
            getValue: fn (): mixed => json_decode(
                $this->filesystem->get(self::composerJson($path)),
                true,
                512,
                JSON_THROW_ON_ERROR
            ),
            strategy: CacheMeStrategy::Memory,
        );
    }

    private static function composerJson(string $path): string
    {
        return $path . '/composer.json';
    }
}
