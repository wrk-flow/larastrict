<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Database\Queries;

use Illuminate\Database\Eloquent\Scope;

interface TestSqlQueryContract
{
    /**
     * @param array<int, Scope|null> $scopes
     */
    public function execute(array $scopes): string;
}
