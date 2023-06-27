<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Debug;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Http\Request;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ExceptionHandlerAssert extends AbstractExpectationCallsMap implements ExceptionHandler
{
    /**
     * @param array<ExceptionHandlerReportExpectation> $report
     * @param array<ExceptionHandlerShouldReportExpectation> $shouldReport
     * @param array<ExceptionHandlerRenderExpectation> $render
     * @param array<ExceptionHandlerRenderForConsoleExpectation> $renderForConsole
     */
    public function __construct(
        array $report = [],
        array $shouldReport = [],
        array $render = [],
        array $renderForConsole = []
    ) {
        $this->setExpectations(ExceptionHandlerReportExpectation::class, array_values(array_filter($report)));
        $this->setExpectations(
            ExceptionHandlerShouldReportExpectation::class,
            array_values(array_filter($shouldReport))
        );
        $this->setExpectations(ExceptionHandlerRenderExpectation::class, array_values(array_filter($render)));
        $this->setExpectations(
            ExceptionHandlerRenderForConsoleExpectation::class,
            array_values(array_filter($renderForConsole))
        );
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

    /**
     * Determine if the exception should be reported.
     *
     * @return bool
     */
    public function shouldReport(Throwable $e)
    {
        $expectation = $this->getExpectation(ExceptionHandlerShouldReportExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->e, $e, $message);

        return $expectation->return;
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @return Response
     */
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
