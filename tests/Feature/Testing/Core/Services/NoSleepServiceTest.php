<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Core\Services;

use LaraStrict\Testing\Core\Services\NoSleepService;
use PHPUnit\Framework\TestCase;

class NoSleepServiceTest extends TestCase
{
    public function testSleepDoesNothing(): void
    {
        $time = microtime(true);
        $noSleep = new NoSleepService();

        $noSleep->sleep(10000);
        $noSleep->sleepRandom(10000, 20000);

        $this->assertTrue(microtime(true) - $time < 0.08);
    }
}
