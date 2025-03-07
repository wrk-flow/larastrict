<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Actions;

use Exception;

final class PathToClassByComposerAction
{
    public function __construct(
        private readonly ComposerAutoloadAbsoluteAction $composerAutoloadAbsoluteAction,
    ) {
    }

    /**
     * @return class-string
     */
    public function execute(string $path): string
    {
        $dirs = $this->composerAutoloadAbsoluteAction->execute();

        $class = $this->replacePathToClass($dirs, $path);
        if ($class === null) {
            $dirs = $this->composerAutoloadAbsoluteAction->execute($path);
            $class = $this->replacePathToClass($dirs, $path);

            if ($class === null) {
                throw new Exception(sprintf('Path "%s" not found in composer psr-4.', $path));
            }
        }

        return $class;
    }

    /**
     * @param array<string, string> $dirs
     *
     * @return class-string|null
     */
    private function replacePathToClass(array $dirs, string $path): ?string
    {
        $map = [];
        foreach ($dirs as $ns => $dir) {
            if (str_starts_with($path, $dir) === false) {
                continue;
            }

            $map[] = [
                'count' => strlen($ns),
                'data' => ['ns' => $ns, 'dir' => $dir],
            ];
        }

        if ($map === []) {
            return null;
        }

        usort($map, static fn(array $a, array $b) => $b['count'] <=> $a['count']);
        ['dir' => $dir, 'ns' => $ns] = $map[0]['data'];

        /** @var class-string $class */
        $class = preg_replace_callback(
            sprintf('~^%s[/\\\](?<path>.*)\.php$~', preg_quote($dir, '~')),
            static fn (array $matches) => $ns . strtr($matches['path'], [
                    '/' => '\\',
                ]),
            $path
        );
        assert(is_string($class));

        return $class;


    }
}
