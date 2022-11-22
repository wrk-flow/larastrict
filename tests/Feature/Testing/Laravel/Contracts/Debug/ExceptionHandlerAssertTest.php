<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Laravel\Contracts\Debug;

use Exception;
use Illuminate\Http\Request;
use LaraStrict\Testing\AbstractExpectationCallsMap;
use LaraStrict\Testing\Concerns\AssertExpectations;
use LaraStrict\Testing\Entities\AssertExpectationEntity;
use LaraStrict\Testing\Laravel\Contracts\Debug\ExceptionHandlerAssert;
use LaraStrict\Testing\Laravel\Contracts\Debug\ExceptionHandlerRenderExpectation;
use LaraStrict\Testing\Laravel\Contracts\Debug\ExceptionHandlerRenderForConsoleExpectation;
use LaraStrict\Testing\Laravel\Contracts\Debug\ExceptionHandlerReportExpectation;
use LaraStrict\Testing\Laravel\Contracts\Debug\ExceptionHandlerShouldReportExpectation;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Output\NullOutput;
use Symfony\Component\HttpFoundation\Response;

class ExceptionHandlerAssertTest extends TestCase
{
    use AssertExpectations;

    protected function generateData(): array
    {
        $exception = new Exception();
        $request = new Request();
        $response = new Response();
        $output = new NullOutput();

        return [
            new AssertExpectationEntity(
                methodName: 'report',
                createAssert: static fn () => new ExceptionHandlerAssert(
                    report: [new ExceptionHandlerReportExpectation($exception)]
                ),
                call: static fn (ExceptionHandlerAssert $assert) => $assert->report($exception),
            ),
            $this->shouldReportAssert(expectedReturn: true),
            $this->shouldReportAssert(expectedReturn: false),
            new AssertExpectationEntity(
                methodName: 'render',
                createAssert: static fn () => new ExceptionHandlerAssert(
                    render: [new ExceptionHandlerRenderExpectation(
                        return: $response,
                        request: $request,
                        e: $exception,
                    )]
                ),
                call: static fn (ExceptionHandlerAssert $assert) => $assert->render($request, $exception),
                checkResult: true,
                expectedResult: $response
            ),
            new AssertExpectationEntity(
                methodName: 'renderForConsole',
                createAssert: static fn () => new ExceptionHandlerAssert(
                    renderForConsole: [new ExceptionHandlerRenderForConsoleExpectation(
                        output: $output,
                        e: $exception,
                    )]
                ),
                call: static fn (ExceptionHandlerAssert $assert) => $assert->renderForConsole($output, $exception),
            ),
        ];
    }

    protected function createEmptyAssert(): AbstractExpectationCallsMap
    {
        return new ExceptionHandlerAssert();
    }

    protected function shouldReportAssert(bool $expectedReturn): AssertExpectationEntity
    {
        $exception = new Exception();

        return new AssertExpectationEntity(
            methodName: 'shouldReport',
            createAssert: static fn () => new ExceptionHandlerAssert(
                shouldReport: [new ExceptionHandlerShouldReportExpectation(return: $expectedReturn, e: $exception,)]
            ),
            call: static fn (ExceptionHandlerAssert $assert) => $assert->shouldReport($exception),
            checkResult: true,
            expectedResult: $expectedReturn
        );
    }
}
