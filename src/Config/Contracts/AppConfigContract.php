<?php

declare(strict_types=1);

namespace LaraStrict\Config\Contracts;

use LaraStrict\Enums\EnvironmentType;

interface AppConfigContract
{
    /**
     * Version from an app (Larastrict projects uses app.version).
     */
    public function getVersion(): string;

    public function getKey(): string;

    public function getUrl(): string;

    public function getAssetUrl(): ?string;

    public function getName(): string;

    public function isInDebugMode(): bool;

    public function getEnvironment(): EnvironmentType|string;
}
