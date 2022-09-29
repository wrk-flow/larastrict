<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\Database\Contracts;

use LaraStrict\Testing\Database\Contracts\RunInTransactionActionContractAssert;
use LaraStrict\Testing\Database\Contracts\RunInTransactionActionContractExpectation;
use PHPUnit\Framework\TestCase;

class RunInTransactionActionContractAssertTest extends TestCase
{
    public function testExecuteWithFirstFailed(): void
    {
        $assert = new RunInTransactionActionContractAssert([
            new RunInTransactionActionContractExpectation(true),
            new RunInTransactionActionContractExpectation(false, 2),
        ]);

        $count = 0;
        $assert->execute(static function () use (&$count) {
            ++$count;
        });

        $this->assertEquals(2, $count);
    }

    public function testExecuteDefaultRunClosureOnce(): void
    {
        $assert = new RunInTransactionActionContractAssert();

        $count = 0;
        $assert->execute(static function () use (&$count) {
            ++$count;
        });

        $this->assertEquals(1, $count);
    }
}
