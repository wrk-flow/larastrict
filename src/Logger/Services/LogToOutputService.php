<?php

declare(strict_types=1);

namespace LaraStrict\Logger\Services;

use Psr\Log\LoggerInterface;
use Stringable;
use Symfony\Component\Console\Style\StyleInterface;

class LogToOutputService implements LoggerInterface
{
    public function __construct(
        private readonly StyleInterface $output
    ) {
    }

    public function emergency(string|Stringable $message, array $context = []): void
    {
        $this->output->note((string) $message);
        $this->writeContext($context);
    }

    public function alert(string|Stringable $message, array $context = []): void
    {
        $this->output->note((string) $message);
        $this->writeContext($context);
    }

    public function critical(string|Stringable $message, array $context = []): void
    {
        $this->output->error((string) $message);
        $this->writeContext($context);
    }

    public function error(string|Stringable $message, array $context = []): void
    {
        $this->output->error((string) $message);
        $this->writeContext($context);
    }

    public function warning(string|Stringable $message, array $context = []): void
    {
        $this->output->warning((string) $message);
        $this->writeContext($context);
    }

    public function notice(string|Stringable $message, array $context = []): void
    {
        $this->output->text((string) $message);
        $this->writeContext($context);
    }

    public function info(string|Stringable $message, array $context = []): void
    {
        $this->output->text('INFO: ' . $message);
        $this->writeContext($context);
    }

    public function debug(string|Stringable $message, array $context = []): void
    {
        $this->output->text((string) $message);
        $this->writeContext($context);
    }

    public function log($level, string|Stringable $message, array $context = []): void
    {
        $this->output->text($level . ': ' . $message);
    }

    protected function writeContext(array $context): void
    {
        if ($context === []) {
            return;
        }

        foreach ($context as $key => $value) {
            // TODO do not use json, use something better
            $normalizedValue = is_string($value) ? $value : json_encode($value, JSON_PRETTY_PRINT);
            $this->output->text(sprintf('   %s: %s', $key, $normalizedValue));
        }

        $this->output->text('');
    }
}
