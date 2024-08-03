<?php

declare(strict_types=1);

namespace LaraStrict\Log\Handlers;

use Illuminate\Console\OutputStyle;
use Illuminate\Console\View\Components\Factory;
use LaraStrict\Log\Managers\ConsoleOutputManager;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Level;
use Monolog\LogRecord;
use Psr\Log\LogLevel;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @internal
 */
final class ConsoleOutputHandler extends AbstractProcessingHandler
{
    /**
     * @param int|string|Level|LogLevel::* $level The minimum logging level at which this handler will be triggered
     *
     * @phpstan-param value-of<Level::VALUES>|value-of<Level::NAMES>|Level|LogLevel::* $level
     */
    public function __construct(
        private readonly ConsoleOutputManager $manager,
        string|int|Level $level = Level::Debug,
        bool $bubble = true,
    ) {
        parent::__construct($level, $bubble);
    }

    protected function write(LogRecord $record): void
    {
        $consoleOutputFactory = $this->manager->getOutputFactory();
        $outputStyle = $this->manager->getOutputStyle();

        if ($consoleOutputFactory instanceof Factory === false || $outputStyle instanceof OutputStyle === false) {
            return;
        }

        if ($outputStyle->getVerbosity() <= OutputInterface::VERBOSITY_QUIET) {
            return;
        }

        $context = $record->context;
        $hasContext = $context !== [];
        $message = $record->message;

        switch ($record['level']) {
            case Level::Notice:
            case Level::Info:
                $consoleOutputFactory->info($message);
                break;
            case Level::Warning:
                $consoleOutputFactory->warn($message);
                break;
            case Level::Alert:
            case Level::Emergency:
            case Level::Critical:
                $consoleOutputFactory->alert($message);
                break;
            case Level::Error:
                $consoleOutputFactory->error($message);
                break;
            case Level::Debug:
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
