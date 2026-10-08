<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Debug;

use Illuminate\Contracts\Debug\ExceptionHandler;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;
use Symfony\Component\Console\Output\OutputInterface;
use Throwable;

class ExceptionHandlerAssert extends AbstractExpectationCallsMap implements ExceptionHandler
{
    /**
     * @param array<ExceptionHandlerReportExpectation|null> $report
     * @param array<ExceptionHandlerShouldReportExpectation|null> $shouldReport
     * @param array<ExceptionHandlerRenderExpectation|null> $render
     * @param array<ExceptionHandlerRenderForConsoleExpectation|null> $renderForConsole
     */
    public function __construct(
        array $report = [],
        array $shouldReport = [],
        array $render = [],
        array $renderForConsole = [],
    ) {
        parent::__construct();
        $this->setExpectations(ExceptionHandlerReportExpectation::class, $report);
        $this->setExpectations(ExceptionHandlerShouldReportExpectation::class, $shouldReport);
        $this->setExpectations(ExceptionHandlerRenderExpectation::class, $render);
        $this->setExpectations(ExceptionHandlerRenderForConsoleExpectation::class, $renderForConsole);
    }

    /**
     * Report or log an exception.
     */
    public function report(Throwable $e)
    {
        $expectation = $this->getExpectation(ExceptionHandlerReportExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->e, $e, $message);
    }

    public function shouldReport(Throwable $e)
    {
        $expectation = $this->getExpectation(ExceptionHandlerShouldReportExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->e, $e, $message);

        return $expectation->return;
    }

    public function render($request, Throwable $e)
    {
        $expectation = $this->getExpectation(ExceptionHandlerRenderExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->request, $request, $message);
        Assert::assertEquals($expectation->e, $e, $message);

        return $expectation->return;
    }

    /**
     * Render an exception to the console.
     *
     * @param OutputInterface $output
     * @internal This method is not meant to be used or overwritten outside the framework.
     */
    public function renderForConsole($output, Throwable $e)
    {
        $expectation = $this->getExpectation(ExceptionHandlerRenderForConsoleExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->output, $output, $message);
        Assert::assertEquals($expectation->e, $e, $message);
    }
}
