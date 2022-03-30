# Laravel strict conventions and features

> Requires PHP 8.1

Main aim of this package is to set of conventions and features to make Laravel more strict and stable proof in long term.

- [Console](./Console/README.md)

## Service providers

Use AbstractServiceProvider that will allow:

- Simple `schedule` definitions 

## Running Laravel in docker environment

> Best practices for running Laravel in docker environment.

1. Run Laravel in separate container with `php-fpm` image for handling HTTP requests.
2. Create nginx container that will use the `php-fpm` container.
3. Run schedule / workers in separate container using `php-cli` image.
4. All log output should be in `json` - this will enable scrapping the logs. 

### Logging

- For development `LOG_CHANNEL=stderr` use `.env`
- For development `LOG_CHANNEL=stderr` use `.env`

```dotenv
LOG_CHANNEL=stderr
```




        'docker' => [
            'driver' => 'monolog',
            'handler' => StreamHandler::class,
            'formatter' => Monolog\Formatter\JsonFormatter::class,
            'with' => [
                'stream' => 'php://stderr',
            ],
        ],
