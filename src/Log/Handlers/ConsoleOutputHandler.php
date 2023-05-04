<?php

declare(strict_types=1);

namespace LaraStrict\Log\Handlers;

use Illuminate\Console\OutputStyle;
use Illuminate\Console\View\Components\Factory;
use LaraStrict\Log\Managers\ConsoleOutputManager;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Symfony\Component\Console\Output\OutputInterface;

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

        if ($outputStyle->getVerbosity() <= OutputInterface::VERBOSITY_QUIET) {
            return;
        }

        $context = $record['context'];
        $hasContext = $context !== [];
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
            case Logger::DEBUG:
                if ($outputStyle->getVerbosity() <= OutputInterface::VERBOSITY_NORMAL) {
                    return;
                }

                $this->writeLine(outputStyle: $outputStyle, message: $message, hasContext: $hasContext);
                break;
            default:
                $this->writeLine(outputStyle: $outputStyle, message: $message, hasContext: $hasContext);
                break;
        }

        if ($hasContext) {
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

            $outputStyle->newLine();
        }
    }

    protected function writeLine(OutputStyle $outputStyle, mixed $message, bool $hasContext): void
    {
        $outputStyle->newLine();
        $outputStyle->write(messages: '  <options=bold>' . $message . '</>');
        $outputStyle->newLine();

        if ($hasContext === false) {
            $outputStyle->newLine();
        }
    }
}
