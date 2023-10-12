<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Core\Services;

use Closure;
use LaraStrict\Core\Contracts\SleepServiceContract;
use LaraStrict\Core\Services\SleepService;
use PHPUnit\Framework\TestCase;

final class SleepServiceTest extends TestCase
{
    private const MinMilliseconds = 100;

    public function testSleep(): void
    {
        $this->assertIsInRange(
            static fn (SleepServiceContract $service) => $service->sleep(milliSeconds: self::MinMilliseconds)
        );
    }

    public function testSleepRandom(): void
    {
        $this->assertIsInRange(
            static fn (SleepServiceContract $service) => $service->sleepRandom(
                fromMilliSeconds: self::MinMilliseconds,
                toMilliSeconds: self::MinMilliseconds + 10
            )
        );
    }

    protected function assertIsInRange(Closure $run): void
    {
        $time = microtime(true);

        $service = new SleepService();
        $run($service);

        $diff = microtime(true) - $time;
        $this->assertTrue($diff > 0.08);
    }
}
