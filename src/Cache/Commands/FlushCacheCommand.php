<?php

declare(strict_types=1);

namespace LaraStrict\Cache\Commands;

use Illuminate\Console\Command;
use LaraStrict\Cache\Services\CacheMeService;

class FlushCacheCommand extends Command
{
    protected $signature = 'cache:flush {tagOrKey} {--key}';
    protected $description = 'Cleans the CacheMeService (memory, Laravel cache) by given tag or key if --key is provided.';

    public function handle(CacheMeService $cacheMeService): void
    {
        $tagOrKey = $this->argument('tagOrKey');

        // Symfony declares a string, but a malformed command definition can still provide another value.
        // @phpstan-ignore function.alreadyNarrowedType
        if (! is_string($tagOrKey)) {
            $this->info('Only string value is supported');
            return;
        }

        if ($this->option('key')) {
            $cacheMeService->delete($tagOrKey);
        } else {
            $cacheMeService->flush([$tagOrKey]);
        }
    }
}
