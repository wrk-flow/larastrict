<?php

declare(strict_types=1);

namespace LaraStrict\Logger\Services;

use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Style\StyleInterface;

class LogToOutputService implements LoggerInterface
{
    private StyleInterface $output;

    public function __construct(StyleInterface $output)
    {
        $this->output = $output;
    }

    public function emergency($message, array $context = []): void
    {
        $this->output->note($message);
        $this->writeContext($context);
    }

    public function alert($message, array $context = []): void
    {
        $this->output->note($message);
        $this->writeContext($context);
    }

    public function critical($message, array $context = []): void
    {
        $this->output->error($message);
        $this->writeContext($context);
    }

    public function error($message, array $context = []): void
    {
        $this->output->error($message);
        $this->writeContext($context);
    }

    public function warning($message, array $context = []): void
    {
        $this->output->warning($message);
        $this->writeContext($context);
    }

    public function notice($message, array $context = []): void
    {
        $this->output->text($message);
        $this->writeContext($context);
    }

    public function info($message, array $context = []): void
    {
        $this->output->info($message);
        $this->writeContext($context);
    }

    public function debug($message, array $context = []): void
    {
        $this->output->text($message);
        $this->writeContext($context);
    }

    public function log($level, $message, array $context = []): void
    {
        $this->output->text($level . ': ' . $message);
    }

    protected function writeContext(array $context): void
    {
        if (empty($context)) {
            return;
        }

        foreach ($context as $key => $value) {
            // TODO do not use json, use something better
            $normalizedValue = is_string($value) ? $value : json_encode($value, JSON_PRETTY_PRINT);
            $this->output->text("   {$key}: {$normalizedValue}");
        }
        $this->output->text('');
    }
}
