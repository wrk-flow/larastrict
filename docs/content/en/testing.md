---
title: Testing
---

The main goal is to prevent using Mockery and implement real mocks that conforms interface of your actions / queries / etc.

It makes it harder to manage the code but will make your test more type safe, easy to refactor and analyze.

You can check this article [testing without mocking frameworks](https://blog.frankdejonge.nl/testing-without-mocking-frameworks/).

## HTTP/s

For HTTP/s we are using package that implements `Psr\Http\Client\ClientInterface` and `Psr\Http\Message\RequestFactoryInterface` 
and we need to correctly test them. 

### Install

```bash
composer require php-http/mock-client
```

### Usage

Use the mock client and then use your current PSR-17 compatible request factory (no need for "mocked" implementation).

```php
$this->client = new \Http\Mock\Client();
$this->requestFactory = new \Nyholm\Psr7\Factory\Psr17Factory;();

// Add responses that will be used.
$this->client
    ->addResponse($this->requestFactory->createResponse(404));

// With HTML content
$response = $this->requestFactory
    ->createResponse()
    ->withBody(\Nyholm\Psr7\Stream::create($html));
```

For more client usage examples check [php-http/mock-client docs](https://docs.php-http.org/en/latest/clients/mock-client.html)

## Laravel Application

We can provide our implementation of `\Illuminate\Contracts\Foundation\Application` and `\Illuminate\Contracts\Container\Container`
to test our logic without Laravel being booted by using `\LaraStrict\Testing\Laravel\TestingApplication`.

Check the code for current state of implementation.

#### Make

We can make objects for `app->make()` calls by providing closure that will build the dependency.

```php
$app = new TestingApplication();
$app->makeReturns(
    abstract: GetMetaDataForUrlPageAction::class,
    make: fn () => new GetMetaDataForUrlPageAction(
        httpClient: new ClientMock(),
        requestFactory: new RequestFactory()
    )
);
```
