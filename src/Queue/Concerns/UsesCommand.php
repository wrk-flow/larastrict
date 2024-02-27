<?php

declare(strict_types=1);

namespace LaraStrict\Queue\Concerns;

use Illuminate\Console\Command;

trait UsesCommand
{
    private ?Command $command = null;

    public function setCommand(Command $command): void
    {
        $this->command = $command;
    }

    public function getCommand(): ?Command
    {
        return $this->command;
    }
}
