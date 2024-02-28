<?php

declare(strict_types=1);

namespace LaraStrict\Queue\Concerns;

use Illuminate\Console\Command;

/**
 * Implementations of UsesCommandInterface. Use this trait to access the command output and other properties. when the
 * job is executed by the RunJobActionContract (not in queue).
 *
 * @see \LaraStrict\Queue\Interfaces\UsesCommandInterface
 */
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
