<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Queue\Actions;

use Illuminate\Console\Command;

final class TestCommand extends Command
{
    protected $signature = 'my:command {--queue}';
}
