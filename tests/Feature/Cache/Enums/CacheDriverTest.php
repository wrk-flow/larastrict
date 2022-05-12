<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Cache\Enums;

use Error;
use Illuminate\Contracts\Cache\Factory;
use Illuminate\Contracts\Cache\Repository;
use InvalidArgumentException;
use LaraStrict\Cache\Enums\CacheDriver;
use Tests\LaraStrict\Feature\TestCase;

class CacheDriverTest extends TestCase
{
    public function test(): void
    {
        $allowedExceptions = [
            'Class "Memcached" not found' => true,
            'Class "Aws\DynamoDb\DynamoDbClient" not found' => true,
        ];

        $cases = 0;
        foreach (CacheDriver::cases() as $driver) {
            try {
                $this->getCache($driver);
            } catch (InvalidArgumentException $invalidArgumentException) {
                $this->fail('Driver does not exists: ' . $invalidArgumentException->getMessage());
            } catch (Error $error) {
                // Do not fail test if memcached extension is not installed.
                if (array_key_exists($error->getMessage(), $allowedExceptions) === false) {
                    $this->fail($error->getMessage());
                }
            }

            ++$cases;
        }

        $this->assertEquals(count(CacheDriver::cases()), $cases);
    }

    protected function getCache(CacheDriver $driver): Repository
    {
        /** @var Factory $factory */
        $factory = $this->app->get(Factory::class);

        return $factory->store($driver->value);
    }
}
