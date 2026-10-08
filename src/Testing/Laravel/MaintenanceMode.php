<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel;

class MaintenanceMode implements \Illuminate\Contracts\Foundation\MaintenanceMode
{
    /**
     * @param array<array-key, mixed> $payload
     */
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

    /**
     * @return array<array-key, mixed>
     */
    public function data(): array
    {
        return [];
    }
}
