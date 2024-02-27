<?php

declare(strict_types=1);

namespace LaraStrict\Queue\Interfaces;

use Illuminate\Console\Command;

/**
 * Implementations of UsesCommand trait
 *
 * @see \LaraStrict\Queue\Concerns\UsesCommand
 */
interface UsesCommandInterface
{
    public function setCommand(Command $command): void;

    public function getCommand(): ?Command;
}
