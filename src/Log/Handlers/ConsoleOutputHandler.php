<?php

declare(strict_types=1);

namespace LaraStrict\Log\Handlers;

use Illuminate\Console\OutputStyle;
use Illuminate\Console\View\Components\Factory;
use LaraStrict\Log\Managers\ConsoleOutputManager;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;

/**
 * @internal
 */
final class ConsoleOutputHandler extends AbstractProcessingHandler
{
    public function __construct(
        private readonly ConsoleOutputManager $manager,
        $level = Logger::DEBUG,
        bool $bubble = true
    ) {
        parent::__construct($level, $bubble);
    }

    protected function write(array $record): void
    {
        $consoleOutputFactory = $this->manager->getOutputFactory();
        $outputStyle = $this->manager->getOutputStyle();

        if ($consoleOutputFactory instanceof Factory === false || $outputStyle instanceof OutputStyle === false) {
            return;
        }

        $message = $record['message'];

        switch ($record['level']) {
            case Logger::NOTICE:
            case Logger::INFO:
                $consoleOutputFactory->info($message);
                break;
            case Logger::WARNING:
                $consoleOutputFactory->warn($message);
                break;
            case Logger::ALERT:
            case Logger::EMERGENCY:
            case Logger::CRITICAL:
                $consoleOutputFactory->alert($message);
                break;
            case Logger::ERROR:
                $consoleOutputFactory->error($message);
                break;
            default:
                $outputStyle->newLine();
                $outputStyle->write(messages: '  <options=bold>' . $message . '</>');
                $outputStyle->newLine();
                break;
        }

        $context = $record['context'];

        if ($context !== []) {
            foreach ($context as $line => $value) {
                $isGenericValue = is_string($value) || is_int($value) || is_float($value) || is_bool($value);

                $stringValue = $isGenericValue
                    ? (string) $value
                    : json_encode(value: $value, flags: JSON_PRETTY_PRINT);

                if ($stringValue === false) {
                    $stringValue = 'Unable to encode value to json';
                }

                $consoleOutputFactory->twoColumnDetail($line, $stringValue);
            }
        }
    }
}
