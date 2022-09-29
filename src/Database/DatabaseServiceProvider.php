<?php

declare(strict_types=1);

namespace LaraStrict\Database;

use Illuminate\Support\ServiceProvider;
use LaraStrict\Database\Actions\RunInTransactionAction;
use LaraStrict\Database\Actions\SafeUniqueSaveAction;
use LaraStrict\Database\Contracts\RunInTransactionActionContract;
use LaraStrict\Database\Contracts\SafeUniqueSaveActionContract;

class DatabaseServiceProvider extends ServiceProvider
{
    public array $bindings = [
        RunInTransactionActionContract::class => RunInTransactionAction::class,
        SafeUniqueSaveActionContract::class => SafeUniqueSaveAction::class,
    ];
}
