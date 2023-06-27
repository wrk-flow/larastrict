<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Laravel\Contracts\Routing;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use LaraStrict\Testing\Concerns\AssertExpectations;
use LaraStrict\Testing\Entities\AssertExpectationEntity;
use LaraStrict\Testing\Laravel\Contracts\Routing\ResponseFactoryAssert;
use LaraStrict\Testing\Laravel\Contracts\Routing\ResponseFactoryDownloadExpectation;
use LaraStrict\Testing\Laravel\Contracts\Routing\ResponseFactoryFileExpectation;
use LaraStrict\Testing\Laravel\Contracts\Routing\ResponseFactoryJsonExpectation;
use LaraStrict\Testing\Laravel\Contracts\Routing\ResponseFactoryJsonpExpectation;
use LaraStrict\Testing\Laravel\Contracts\Routing\ResponseFactoryMakeExpectation;
use LaraStrict\Testing\Laravel\Contracts\Routing\ResponseFactoryNoContentExpectation;
use LaraStrict\Testing\Laravel\Contracts\Routing\ResponseFactoryRedirectGuestExpectation;
use LaraStrict\Testing\Laravel\Contracts\Routing\ResponseFactoryRedirectToActionExpectation;
use LaraStrict\Testing\Laravel\Contracts\Routing\ResponseFactoryRedirectToExpectation;
use LaraStrict\Testing\Laravel\Contracts\Routing\ResponseFactoryRedirectToIntendedExpectation;
use LaraStrict\Testing\Laravel\Contracts\Routing\ResponseFactoryRedirectToRouteExpectation;
use LaraStrict\Testing\Laravel\Contracts\Routing\ResponseFactoryStreamDownloadExpectation;
use LaraStrict\Testing\Laravel\Contracts\Routing\ResponseFactoryStreamExpectation;
use LaraStrict\Testing\Laravel\Contracts\Routing\ResponseFactoryViewExpectation;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ResponseFactoryAssertTest extends TestCase
{
    use AssertExpectations;

    protected function generateData(): array
    {
        $response = new Response();
        $redirectResponse = new RedirectResponse('https://larastrict.com');
        $binaryFileResponse = new BinaryFileResponse(__FILE__);
        $streamResponse = new StreamedResponse();
        $jsonResponse = new JsonResponse();
        $assertStreamCallback = static function ($callback) {
            self::assertEquals('stream', $callback());
        };
        $streamCallback = static fn () => 'stream';
        return [
            new AssertExpectationEntity(
                methodName: 'make',
                createAssert: static fn () => new ResponseFactoryAssert(make: [
                    new ResponseFactoryMakeExpectation(return: $response),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->make(),
                checkResult: true,
                expectedResult: $response
            ),
            new AssertExpectationEntity(
                methodName: 'make',
                createAssert: static fn () => new ResponseFactoryAssert(make: [
                    new ResponseFactoryMakeExpectation(return: $response, content: 'Content'),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->make(content: 'Content'),
                checkResult: true,
                expectedResult: $response
            ),
            new AssertExpectationEntity(
                methodName: 'make',
                createAssert: static fn () => new ResponseFactoryAssert(make: [
                    new ResponseFactoryMakeExpectation(return: $response, content: 'Content', status: 203),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->make(content: 'Content', status: 203),
                checkResult: true,
                expectedResult: $response
            ),
            new AssertExpectationEntity(
                methodName: 'make',
                createAssert: static fn () => new ResponseFactoryAssert(make: [
                    new ResponseFactoryMakeExpectation(return: $response, content: 'Content', status: 203, headers: [
                        'header' => ['value'],
                    ]),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->make(
                    content: 'Content',
                    status: 203,
                    headers: [
                        'header' => ['value'],
                    ]
                ),
                checkResult: true,
                expectedResult: $response
            ),
            new AssertExpectationEntity(
                methodName: 'noContent',
                createAssert: static fn () => new ResponseFactoryAssert(noContent: [
                    new ResponseFactoryNoContentExpectation(return: $response),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->noContent(),
                checkResult: true,
                expectedResult: $response
            ),
            new AssertExpectationEntity(
                methodName: 'noContent',
                createAssert: static fn () => new ResponseFactoryAssert(noContent: [
                    new ResponseFactoryNoContentExpectation(return: $response, status: 203),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->noContent(status: 203),
                checkResult: true,
                expectedResult: $response
            ),
            new AssertExpectationEntity(
                methodName: 'noContent',
                createAssert: static fn () => new ResponseFactoryAssert(noContent: [
                    new ResponseFactoryNoContentExpectation(return: $response, status: 203, headers: [
                        'header' => ['value'],
                    ]),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->noContent(status: 203, headers: [
                    'header' => ['value'],
                ]),
                checkResult: true,
                expectedResult: $response
            ),
            new AssertExpectationEntity(
                methodName: 'view',
                createAssert: static fn () => new ResponseFactoryAssert(view: [
                    new ResponseFactoryViewExpectation(return: $response, view: 'test'),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->view(view: 'test'),
                checkResult: true,
                expectedResult: $response
            ),
            new AssertExpectationEntity(
                methodName: 'view',
                createAssert: static fn () => new ResponseFactoryAssert(view: [
                    new ResponseFactoryViewExpectation(return: $response, view: 'test', status: 203),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->view(view: 'test', status: 203),
                checkResult: true,
                expectedResult: $response
            ),
            new AssertExpectationEntity(
                methodName: 'view',
                createAssert: static fn () => new ResponseFactoryAssert(view: [
                    new ResponseFactoryViewExpectation(return: $response, view: 'test', status: 203, headers: [
                        'header' => ['value'],
                    ]),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->view(view: 'test', status: 203, headers: [
                    'header' => ['value'],
                ]),
                checkResult: true,
                expectedResult: $response
            ),
            new AssertExpectationEntity(
                methodName: 'json',
                createAssert: static fn () => new ResponseFactoryAssert(json: [
                    new ResponseFactoryJsonExpectation(return: $jsonResponse, data: ['test']),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->json(data: ['test']),
                checkResult: true,
                expectedResult: $jsonResponse
            ),
            new AssertExpectationEntity(
                methodName: 'json',
                createAssert: static fn () => new ResponseFactoryAssert(json: [
                    new ResponseFactoryJsonExpectation(return: $jsonResponse, data: ['test'], status: 203),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->json(data: ['test'], status: 203),
                checkResult: true,
                expectedResult: $jsonResponse
            ),
            new AssertExpectationEntity(
                methodName: 'json',
                createAssert: static fn () => new ResponseFactoryAssert(json: [
                    new ResponseFactoryJsonExpectation(return: $jsonResponse, data: ['test'], status: 203, headers: [
                        'header' => ['value'],
                    ]),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->json(data: ['test'], status: 203, headers: [
                    'header' => ['value'],
                ]),
                checkResult: true,
                expectedResult: $jsonResponse
            ),
            new AssertExpectationEntity(
                methodName: 'jsonp',
                createAssert: static fn () => new ResponseFactoryAssert(jsonp: [
                    new ResponseFactoryJsonpExpectation(return: $jsonResponse, callback: 'test'),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->jsonp(callback: 'test'),
                checkResult: true,
                expectedResult: $jsonResponse
            ),
            new AssertExpectationEntity(
                methodName: 'jsonp',
                createAssert: static fn () => new ResponseFactoryAssert(jsonp: [
                    new ResponseFactoryJsonpExpectation(return: $jsonResponse, callback: 'test', status: 203),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->jsonp(callback: 'test', status: 203),
                checkResult: true,
                expectedResult: $jsonResponse
            ),
            new AssertExpectationEntity(
                methodName: 'jsonp',
                createAssert: static fn () => new ResponseFactoryAssert(jsonp: [
                    new ResponseFactoryJsonpExpectation(return: $jsonResponse, callback: 'test', status: 203, headers: [
                        'header' => ['value'],
                    ]),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->jsonp(
                    callback: 'test',
                    status: 203,
                    headers: [
                        'header' => ['value'],
                    ]
                ),
                checkResult: true,
                expectedResult: $jsonResponse
            ),
            new AssertExpectationEntity(
                methodName: 'stream',
                createAssert: static fn () => new ResponseFactoryAssert(stream: [
                    new ResponseFactoryStreamExpectation(return: $streamResponse, hook: $assertStreamCallback),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->stream(callback: $streamCallback),
                checkResult: true,
                expectedResult: $streamResponse
            ),
            new AssertExpectationEntity(
                methodName: 'stream',
                createAssert: static fn () => new ResponseFactoryAssert(stream: [
                    new ResponseFactoryStreamExpectation(
                        return: $streamResponse,
                        status: 203,
                        hook: $assertStreamCallback
                    ),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->stream(
                    callback: $streamCallback,
                    status: 203
                ),
                checkResult: true,
                expectedResult: $streamResponse
            ),
            new AssertExpectationEntity(
                methodName: 'stream',
                createAssert: static fn () => new ResponseFactoryAssert(stream: [
                    new ResponseFactoryStreamExpectation(return: $streamResponse, status: 203, headers: [
                        'header' => ['value'],
                    ], hook: $assertStreamCallback),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->stream(
                    callback: $streamCallback,
                    status: 203,
                    headers: [
                        'header' => ['value'],
                    ]
                ),
                checkResult: true,
                expectedResult: $streamResponse
            ),
            new AssertExpectationEntity(
                methodName: 'streamDownload',
                createAssert: static fn () => new ResponseFactoryAssert(streamDownload: [
                    new ResponseFactoryStreamDownloadExpectation(return: $streamResponse, hook: $assertStreamCallback),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->streamDownload(callback: $streamCallback),
                checkResult: true,
                expectedResult: $streamResponse
            ),
            new AssertExpectationEntity(
                methodName: 'streamDownload',
                createAssert: static fn () => new ResponseFactoryAssert(streamDownload: [
                    new ResponseFactoryStreamDownloadExpectation(
                        return: $streamResponse,
                        name: 'test',
                        hook: $assertStreamCallback
                    ),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->streamDownload(
                    callback: $streamCallback,
                    name: 'test'
                ),
                checkResult: true,
                expectedResult: $streamResponse
            ),
            new AssertExpectationEntity(
                methodName: 'streamDownload',
                createAssert: static fn () => new ResponseFactoryAssert(streamDownload: [
                    new ResponseFactoryStreamDownloadExpectation(return: $streamResponse, name: 'test', headers: [
                        'header' => ['value'],
                    ], hook: $assertStreamCallback),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->streamDownload(
                    callback: $streamCallback,
                    name: 'test',
                    headers: [
                        'header' => ['value'],
                    ]
                ),
                checkResult: true,
                expectedResult: $streamResponse
            ),
            new AssertExpectationEntity(
                methodName: 'streamDownload',
                createAssert: static fn () => new ResponseFactoryAssert(streamDownload: [
                    new ResponseFactoryStreamDownloadExpectation(return: $streamResponse, name: 'test', headers: [
                        'header' => ['value'],
                    ], disposition: 'inline', hook: $assertStreamCallback),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->streamDownload(
                    callback: $streamCallback,
                    name: 'test',
                    headers: [
                        'header' => ['value'],
                    ],
                    disposition: 'inline'
                ),
                checkResult: true,
                expectedResult: $streamResponse
            ),
            new AssertExpectationEntity(
                methodName: 'download',
                createAssert: static fn () => new ResponseFactoryAssert(download: [
                    new ResponseFactoryDownloadExpectation(return: $binaryFileResponse, file: 'file'),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->download(file: 'file'),
                checkResult: true,
                expectedResult: $binaryFileResponse
            ),
            new AssertExpectationEntity(
                methodName: 'download',
                createAssert: static fn () => new ResponseFactoryAssert(download: [
                    new ResponseFactoryDownloadExpectation(return: $binaryFileResponse, file: 'file', name: 'test'),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->download(file: 'file', name: 'test'),
                checkResult: true,
                expectedResult: $binaryFileResponse
            ),
            new AssertExpectationEntity(
                methodName: 'download',
                createAssert: static fn () => new ResponseFactoryAssert(download: [
                    new ResponseFactoryDownloadExpectation(return: $binaryFileResponse, file: 'file', name: 'test', headers: [
                        'header' => ['value'],
                    ]),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->download(
                    file: 'file',
                    name: 'test',
                    headers: [
                        'header' => ['value'],
                    ]
                ),
                checkResult: true,
                expectedResult: $binaryFileResponse
            ),
            new AssertExpectationEntity(
                methodName: 'download',
                createAssert: static fn () => new ResponseFactoryAssert(download: [
                    new ResponseFactoryDownloadExpectation(return: $binaryFileResponse, file: 'file', name: 'test', headers: [
                        'header' => ['value'],
                    ], disposition: 'inline'),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->download(
                    file: 'file',
                    name: 'test',
                    headers: [
                        'header' => ['value'],
                    ],
                    disposition: 'inline'
                ),
                checkResult: true,
                expectedResult: $binaryFileResponse
            ),
            new AssertExpectationEntity(
                methodName: 'file',
                createAssert: static fn () => new ResponseFactoryAssert(file: [
                    new ResponseFactoryFileExpectation(return: $binaryFileResponse, file: 'file'),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->file(file: 'file'),
                checkResult: true,
                expectedResult: $binaryFileResponse
            ),
            new AssertExpectationEntity(
                methodName: 'file',
                createAssert: static fn () => new ResponseFactoryAssert(file: [
                    new ResponseFactoryFileExpectation(return: $binaryFileResponse, file: 'file', headers: [
                        'header' => ['value'],
                    ]),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->file(file: 'file', headers: [
                    'header' => ['value'],
                ]),
                checkResult: true,
                expectedResult: $binaryFileResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectTo',
                createAssert: static fn () => new ResponseFactoryAssert(redirectTo: [
                    new ResponseFactoryRedirectToExpectation(return: $redirectResponse, path: 'test'),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectTo(path: 'test'),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectTo',
                createAssert: static fn () => new ResponseFactoryAssert(redirectTo: [
                    new ResponseFactoryRedirectToExpectation(return: $redirectResponse, path: 'test', status: 203),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectTo(path: 'test', status: 203),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectTo',
                createAssert: static fn () => new ResponseFactoryAssert(redirectTo: [
                    new ResponseFactoryRedirectToExpectation(return: $redirectResponse, path: 'test', status: 203, headers: [
                        'header' => ['value'],
                    ]),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectTo(
                    path: 'test',
                    status: 203,
                    headers: [
                        'header' => ['value'],
                    ]
                ),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectTo',
                createAssert: static fn () => new ResponseFactoryAssert(redirectTo: [
                    new ResponseFactoryRedirectToExpectation(return: $redirectResponse, path: 'test', status: 203, headers: [
                        'header' => ['value'],
                    ], secure: true),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectTo(
                    path: 'test',
                    status: 203,
                    headers: [
                        'header' => ['value'],
                    ],
                    secure: true
                ),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectToRoute',
                createAssert: static fn () => new ResponseFactoryAssert(redirectToRoute: [
                    new ResponseFactoryRedirectToRouteExpectation(return: $redirectResponse, route: 'test'),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectToRoute(route: 'test'),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectToRoute',
                createAssert: static fn () => new ResponseFactoryAssert(redirectToRoute: [
                    new ResponseFactoryRedirectToRouteExpectation(
                        return: $redirectResponse,
                        route: 'test',
                        status: 203
                    ),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectToRoute(route: 'test', status: 203),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectToRoute',
                createAssert: static fn () => new ResponseFactoryAssert(redirectToRoute: [
                    new ResponseFactoryRedirectToRouteExpectation(return: $redirectResponse, route: 'test', status: 203, headers: [
                        'header' => ['value'],
                    ]),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectToRoute(
                    route: 'test',
                    status: 203,
                    headers: [
                        'header' => ['value'],
                    ]
                ),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectToAction',
                createAssert: static fn () => new ResponseFactoryAssert(redirectToAction: [
                    new ResponseFactoryRedirectToActionExpectation(return: $redirectResponse, action: 'test'),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectToAction(action: 'test'),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectToAction',
                createAssert: static fn () => new ResponseFactoryAssert(redirectToAction: [
                    new ResponseFactoryRedirectToActionExpectation(return: $redirectResponse, action: 'test', parameters: [
                        'param' => true,
                    ]),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectToAction(
                    action: 'test',
                    parameters: [
                        'param' => true,
                    ]
                ),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectToAction',
                createAssert: static fn () => new ResponseFactoryAssert(redirectToAction: [
                    new ResponseFactoryRedirectToActionExpectation(return: $redirectResponse, action: 'test', parameters: [
                        'param' => true,
                    ], status: 203),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectToAction(
                    action: 'test',
                    parameters: [
                        'param' => true,
                    ],
                    status: 203
                ),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectToAction',
                createAssert: static fn () => new ResponseFactoryAssert(redirectToAction: [
                    new ResponseFactoryRedirectToActionExpectation(return: $redirectResponse, action: 'test', parameters: [
                        'param' => true,
                    ], status: 203, headers: [
                        'header' => ['value'],
                    ]),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectToAction(
                    action: 'test',
                    parameters: [
                        'param' => true,
                    ],
                    status: 203,
                    headers: [
                        'header' => ['value'],
                    ]
                ),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectGuest',
                createAssert: static fn () => new ResponseFactoryAssert(redirectGuest: [
                    new ResponseFactoryRedirectGuestExpectation(return: $redirectResponse, path: 'test'),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectGuest(path: 'test'),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectGuest',
                createAssert: static fn () => new ResponseFactoryAssert(redirectGuest: [
                    new ResponseFactoryRedirectGuestExpectation(return: $redirectResponse, path: 'test', status: 203),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectGuest(path: 'test', status: 203),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectGuest',
                createAssert: static fn () => new ResponseFactoryAssert(redirectGuest: [
                    new ResponseFactoryRedirectGuestExpectation(return: $redirectResponse, path: 'test', status: 203, headers: [
                        'header' => ['value'],
                    ]),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectGuest(
                    path: 'test',
                    status: 203,
                    headers: [
                        'header' => ['value'],
                    ]
                ),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectGuest',
                createAssert: static fn () => new ResponseFactoryAssert(redirectGuest: [
                    new ResponseFactoryRedirectGuestExpectation(return: $redirectResponse, path: 'test', status: 203, headers: [
                        'header' => ['value'],
                    ], secure: true),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectGuest(
                    path: 'test',
                    status: 203,
                    headers: [
                        'header' => ['value'],
                    ],
                    secure: true
                ),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectToIntended',
                createAssert: static fn () => new ResponseFactoryAssert(redirectToIntended: [
                    new ResponseFactoryRedirectToIntendedExpectation(return: $redirectResponse),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectToIntended(),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectToIntended',
                createAssert: static fn () => new ResponseFactoryAssert(redirectToIntended: [
                    new ResponseFactoryRedirectToIntendedExpectation(return: $redirectResponse, default: 'test'),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectToIntended(default: 'test'),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectToIntended',
                createAssert: static fn () => new ResponseFactoryAssert(redirectToIntended: [
                    new ResponseFactoryRedirectToIntendedExpectation(
                        return: $redirectResponse,
                        default: 'test',
                        status: 203
                    ),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectToIntended(
                    default: 'test',
                    status: 203
                ),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectToIntended',
                createAssert: static fn () => new ResponseFactoryAssert(redirectToIntended: [
                    new ResponseFactoryRedirectToIntendedExpectation(return: $redirectResponse, default: 'test', status: 203, headers: [
                        'header' => ['value'],
                    ]),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectToIntended(
                    default: 'test',
                    status: 203,
                    headers: [
                        'header' => ['value'],
                    ]
                ),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
            new AssertExpectationEntity(
                methodName: 'redirectToIntended',
                createAssert: static fn () => new ResponseFactoryAssert(redirectToIntended: [
                    new ResponseFactoryRedirectToIntendedExpectation(return: $redirectResponse, default: 'test', status: 203, headers: [
                        'header' => ['value'],
                    ], secure: true),
                ]),
                call: static fn (ResponseFactoryAssert $assert) => $assert->redirectToIntended(
                    default: 'test',
                    status: 203,
                    headers: [
                        'header' => ['value'],
                    ],
                    secure: true
                ),
                checkResult: true,
                expectedResult: $redirectResponse
            ),
        ];
    }

    protected function createEmptyAssert(): AbstractExpectationCallsMap
    {
        return new ResponseFactoryAssert();
    }
}
