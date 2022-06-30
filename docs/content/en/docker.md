---
title: Docker
---

## Running Laravel in docker environment

> Best practices for running Laravel in docker environment.

1. Run Laravel in separate container with `php-fpm` image for handling HTTP requests.
2. Create nginx container that will use the `php-fpm` container.
3. Run schedule / workers in separate container using `php-cli` image.
4. All log output should be in `json` - this will enable scrapping the logs.

### Logging

#### Development

- For development `LOG_CHANNEL=stderr` use `.env`

```dotenv
LOG_CHANNEL=stderr
```

#### Production

> For production you want always to use JSON to be able to parse it for ELK or any other setup

- For development `LOG_CHANNEL=docker` use `.env`
- Update your `logging.php`

```php
'docker' => [
    'driver' => 'monolog',
    'handler' => StreamHandler::class,
    'formatter' => Monolog\Formatter\JsonFormatter::class,
    'with' => [
        'stream' => 'php://stderr',
    ],
],
```
