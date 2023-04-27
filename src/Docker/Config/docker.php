<?php

declare(strict_types=1);

use LaraStrict\Docker\Config\DockerConfig;

return [
    DockerConfig::KeyInDockerEnvironment => env('IS_DOCKER_ENVIRONMENT', false),
    DockerConfig::KeyOutputProcess => env('DOCKER_OUTPUT_PROCESS', '/proc/1/fd/1'),
];
