<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Log\Managers;

use Illuminate\Log\Logger;
use Illuminate\Log\LogManager;
use Illuminate\Support\Env;
use LaraStrict\Log\Managers\ConsoleOutputManager;
use Tests\LaraStrict\Feature\TestCase;

class ConsoleOutputManagerTest extends TestCase
{
    public function testLaravelCanBindAndResolveTheConsoleLogDriverFactory(): void
    {
        $environment = Env::getRepository();
        $originalTerm = $environment->get('TERM');
        $environment->set('TERM', 'xterm');

        try {
            $this->make(ConsoleOutputManager::class)->boot();

            $logManager = $this->app()
                ->make(LogManager::class);
            $logger = $logManager->channel('larastrict_console_output');

            $this->assertInstanceOf(Logger::class, $logger);
        } finally {
            if ($originalTerm === null) {
                $environment->clear('TERM');
            } else {
                $environment->set('TERM', $originalTerm);
            }
        }
    }
}
