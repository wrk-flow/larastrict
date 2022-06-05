<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel;

use Psr\Log\LoggerInterface;
use Stringable;

class Logger implements LoggerInterface
{
    public array $emergency = [];

    public array $alert = [];

    public array $critical = [];

    public array $error = [];

    public array $warning = [];

    public array $notice = [];

    public array $info = [];

    public array $debug = [];

    public array $log = [];

    public function emergency(Stringable|string $message, array $context = []): void
    {
        $this->emergency[] = [$message, $context];
    }

    public function alert(Stringable|string $message, array $context = []): void
    {
        $this->alert[] = [$message, $context];
    }

    public function critical(Stringable|string $message, array $context = []): void
    {
        $this->critical[] = [$message, $context];
    }

    public function error(Stringable|string $message, array $context = []): void
    {
        $this->error[] = [$message, $context];
    }

    public function warning(Stringable|string $message, array $context = []): void
    {
        $this->warning[] = [$message, $context];
    }

    public function notice(Stringable|string $message, array $context = []): void
    {
        $this->notice[] = [$message, $context];
    }

    public function info(Stringable|string $message, array $context = []): void
    {
        $this->info[] = [$message, $context];
    }

    public function debug(Stringable|string $message, array $context = []): void
    {
        $this->debug[] = [$message, $context];
    }

    public function log($level, Stringable|string $message, array $context = []): void
    {
        $this->log[] = [$message, $context];
    }
}
