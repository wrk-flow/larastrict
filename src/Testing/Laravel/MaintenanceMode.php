<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel;

class MaintenanceMode implements \Illuminate\Contracts\Foundation\MaintenanceMode
{
    public function activate(array $payload): void
    {
    }

    public function deactivate(): void
    {
    }

    public function active(): bool
    {
        return true;
    }

    public function data(): array
    {
        return [];
    }
}
