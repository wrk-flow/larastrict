<?php

declare(strict_types=1);

namespace LaraStrict\Queue\Interfaces;

use Illuminate\Console\Command;

/**
 * Use this interface to access the command output and other properties with combination with UsesCommand trait.
 *
 * @see \LaraStrict\Queue\Interfaces\UsesCommandInterface
 */
interface UsesCommandInterface
{
    /**
     * Command is set when the job is executed by the RunJobActionContract (not in queue). You can use this to access
     * the command output and other properties.
     */
    public function setCommand(Command $command): void;

    public function getCommand(): ?Command;
}
