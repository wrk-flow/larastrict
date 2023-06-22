<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Routing;

use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use LaraStrict\Testing\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;
use SplFileInfo;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ResponseFactoryAssert extends AbstractExpectationCallsMap implements ResponseFactory
{
    /**
     * @param array<ResponseFactoryMakeExpectation|null> $make
     * @param array<ResponseFactoryNoContentExpectation|null> $noContent
     * @param array<ResponseFactoryViewExpectation|null> $view
     * @param array<ResponseFactoryJsonExpectation|null> $json
     * @param array<ResponseFactoryJsonpExpectation|null> $jsonp
     * @param array<ResponseFactoryStreamExpectation|null> $stream
     * @param array<ResponseFactoryStreamDownloadExpectation|null> $streamDownload
     * @param array<ResponseFactoryDownloadExpectation|null> $download
     * @param array<ResponseFactoryFileExpectation|null> $file
     * @param array<ResponseFactoryRedirectToExpectation|null> $redirectTo
     * @param array<ResponseFactoryRedirectToRouteExpectation|null> $redirectToRoute
     * @param array<ResponseFactoryRedirectToActionExpectation|null> $redirectToAction
     * @param array<ResponseFactoryRedirectGuestExpectation|null> $redirectGuest
     * @param array<ResponseFactoryRedirectToIntendedExpectation|null> $redirectToIntended
     */
    public function __construct(
        array $make = [],
        array $noContent = [],
        array $view = [],
        array $json = [],
        array $jsonp = [],
        array $stream = [],
        array $streamDownload = [],
        array $download = [],
        array $file = [],
        array $redirectTo = [],
        array $redirectToRoute = [],
        array $redirectToAction = [],
        array $redirectGuest = [],
        array $redirectToIntended = [],
    ) {
        $this->setExpectations(ResponseFactoryMakeExpectation::class, array_values(array_filter($make)));
        $this->setExpectations(ResponseFactoryNoContentExpectation::class, array_values(array_filter($noContent)));
        $this->setExpectations(ResponseFactoryViewExpectation::class, array_values(array_filter($view)));
        $this->setExpectations(ResponseFactoryJsonExpectation::class, array_values(array_filter($json)));
        $this->setExpectations(ResponseFactoryJsonpExpectation::class, array_values(array_filter($jsonp)));
        $this->setExpectations(ResponseFactoryStreamExpectation::class, array_values(array_filter($stream)));
        $this->setExpectations(
            ResponseFactoryStreamDownloadExpectation::class,
            array_values(array_filter($streamDownload))
        );
        $this->setExpectations(ResponseFactoryDownloadExpectation::class, array_values(array_filter($download)));
        $this->setExpectations(ResponseFactoryFileExpectation::class, array_values(array_filter($file)));
        $this->setExpectations(ResponseFactoryRedirectToExpectation::class, array_values(array_filter($redirectTo)));
        $this->setExpectations(
            ResponseFactoryRedirectToRouteExpectation::class,
            array_values(array_filter($redirectToRoute))
        );
        $this->setExpectations(
            ResponseFactoryRedirectToActionExpectation::class,
            array_values(array_filter($redirectToAction))
        );
        $this->setExpectations(
            ResponseFactoryRedirectGuestExpectation::class,
            array_values(array_filter($redirectGuest))
        );
        $this->setExpectations(
            ResponseFactoryRedirectToIntendedExpectation::class,
            array_values(array_filter($redirectToIntended))
        );
    }

    /**
     * Create a new response instance.
     *
     * @param  array|string  $content
     * @param  int  $status
     * @return Response
     */
    public function make($content = '', $status = 200, array $headers = [])
    {
        $expectation = $this->getExpectation(ResponseFactoryMakeExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->content, $content, $message);
        Assert::assertEquals($expectation->status, $status, $message);
        Assert::assertEquals($expectation->headers, $headers, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $content, $status, $headers, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Create a new "no content" response.
     *
     * @param  int  $status
     * @return Response
     */
    public function noContent($status = 204, array $headers = [])
    {
        $expectation = $this->getExpectation(ResponseFactoryNoContentExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->status, $status, $message);
        Assert::assertEquals($expectation->headers, $headers, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $status, $headers, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Create a new response for a given view.
     *
     * @param  string|array  $view
     * @param  array  $data
     * @param  int  $status
     * @return Response
     */
    public function view($view, $data = [], $status = 200, array $headers = [])
    {
        $expectation = $this->getExpectation(ResponseFactoryViewExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->view, $view, $message);
        Assert::assertEquals($expectation->data, $data, $message);
        Assert::assertEquals($expectation->status, $status, $message);
        Assert::assertEquals($expectation->headers, $headers, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $view, $data, $status, $headers, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Create a new JSON response instance.
     *
     * @param  mixed  $data
     * @param  int  $status
     * @param  int  $options
     * @return JsonResponse
     */
    public function json($data = [], $status = 200, array $headers = [], $options = 0)
    {
        $expectation = $this->getExpectation(ResponseFactoryJsonExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->data, $data, $message);
        Assert::assertEquals($expectation->status, $status, $message);
        Assert::assertEquals($expectation->headers, $headers, $message);
        Assert::assertEquals($expectation->options, $options, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $data, $status, $headers, $options, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Create a new JSONP response instance.
     *
     * @param  string  $callback
     * @param  mixed  $data
     * @param  int  $status
     * @param  int  $options
     * @return JsonResponse
     */
    public function jsonp($callback, $data = [], $status = 200, array $headers = [], $options = 0)
    {
        $expectation = $this->getExpectation(ResponseFactoryJsonpExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->callback, $callback, $message);
        Assert::assertEquals($expectation->data, $data, $message);
        Assert::assertEquals($expectation->status, $status, $message);
        Assert::assertEquals($expectation->headers, $headers, $message);
        Assert::assertEquals($expectation->options, $options, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $callback, $data, $status, $headers, $options, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Create a new streamed response instance.
     *
     * @param  callable  $callback
     * @param  int  $status
     * @return StreamedResponse
     */
    public function stream($callback, $status = 200, array $headers = [])
    {
        $expectation = $this->getExpectation(ResponseFactoryStreamExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->status, $status, $message);
        Assert::assertEquals($expectation->headers, $headers, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $callback, $status, $headers, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Create a new streamed response instance as a file download.
     *
     * @param  callable  $callback
     * @param  string|null  $name
     * @param  string|null  $disposition
     * @return StreamedResponse
     */
    public function streamDownload($callback, $name = null, array $headers = [], $disposition = 'attachment')
    {
        $expectation = $this->getExpectation(ResponseFactoryStreamDownloadExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->name, $name, $message);
        Assert::assertEquals($expectation->headers, $headers, $message);
        Assert::assertEquals($expectation->disposition, $disposition, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $callback, $name, $headers, $disposition, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Create a new file download response.
     *
     * @param SplFileInfo|string $file
     * @param  string|null  $name
     * @param  string|null  $disposition
     * @return BinaryFileResponse
     */
    public function download($file, $name = null, array $headers = [], $disposition = 'attachment')
    {
        $expectation = $this->getExpectation(ResponseFactoryDownloadExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->file, $file, $message);
        Assert::assertEquals($expectation->name, $name, $message);
        Assert::assertEquals($expectation->headers, $headers, $message);
        Assert::assertEquals($expectation->disposition, $disposition, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $file, $name, $headers, $disposition, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Return the raw contents of a binary file.
     *
     * @param SplFileInfo|string $file
     * @return BinaryFileResponse
     */
    public function file($file, array $headers = [])
    {
        $expectation = $this->getExpectation(ResponseFactoryFileExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->file, $file, $message);
        Assert::assertEquals($expectation->headers, $headers, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $file, $headers, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Create a new redirect response to the given path.
     *
     * @param  string  $path
     * @param  int  $status
     * @param  array  $headers
     * @param  bool|null  $secure
     * @return RedirectResponse
     */
    public function redirectTo($path, $status = 302, $headers = [], $secure = null)
    {
        $expectation = $this->getExpectation(ResponseFactoryRedirectToExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->path, $path, $message);
        Assert::assertEquals($expectation->status, $status, $message);
        Assert::assertEquals($expectation->headers, $headers, $message);
        Assert::assertEquals($expectation->secure, $secure, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $path, $status, $headers, $secure, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Create a new redirect response to a named route.
     *
     * @param  string  $route
     * @param  mixed  $parameters
     * @param  int  $status
     * @param  array  $headers
     * @return RedirectResponse
     */
    public function redirectToRoute($route, $parameters = [], $status = 302, $headers = [])
    {
        $expectation = $this->getExpectation(ResponseFactoryRedirectToRouteExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->route, $route, $message);
        Assert::assertEquals($expectation->parameters, $parameters, $message);
        Assert::assertEquals($expectation->status, $status, $message);
        Assert::assertEquals($expectation->headers, $headers, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $route, $parameters, $status, $headers, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Create a new redirect response to a controller action.
     *
     * @param  string  $action
     * @param  mixed  $parameters
     * @param  int  $status
     * @param  array  $headers
     * @return RedirectResponse
     */
    public function redirectToAction($action, $parameters = [], $status = 302, $headers = [])
    {
        $expectation = $this->getExpectation(ResponseFactoryRedirectToActionExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->action, $action, $message);
        Assert::assertEquals($expectation->parameters, $parameters, $message);
        Assert::assertEquals($expectation->status, $status, $message);
        Assert::assertEquals($expectation->headers, $headers, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $action, $parameters, $status, $headers, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Create a new redirect response, while putting the current URL in the session.
     *
     * @param  string  $path
     * @param  int  $status
     * @param  array  $headers
     * @param  bool|null  $secure
     * @return RedirectResponse
     */
    public function redirectGuest($path, $status = 302, $headers = [], $secure = null)
    {
        $expectation = $this->getExpectation(ResponseFactoryRedirectGuestExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->path, $path, $message);
        Assert::assertEquals($expectation->status, $status, $message);
        Assert::assertEquals($expectation->headers, $headers, $message);
        Assert::assertEquals($expectation->secure, $secure, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $path, $status, $headers, $secure, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Create a new redirect response to the previously intended location.
     *
     * @param  string  $default
     * @param  int  $status
     * @param  array  $headers
     * @param  bool|null  $secure
     * @return RedirectResponse
     */
    public function redirectToIntended($default = '/', $status = 302, $headers = [], $secure = null)
    {
        $expectation = $this->getExpectation(ResponseFactoryRedirectToIntendedExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->default, $default, $message);
        Assert::assertEquals($expectation->status, $status, $message);
        Assert::assertEquals($expectation->headers, $headers, $message);
        Assert::assertEquals($expectation->secure, $secure, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $default, $status, $headers, $secure, $expectation);
        }

        return $expectation->return;
    }
}
