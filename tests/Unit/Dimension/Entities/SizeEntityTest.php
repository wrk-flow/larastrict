<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Dimension\Entities;

use LaraStrict\Dimension\Entities\SizeEntity;
use PHPUnit\Framework\TestCase;

class SizeEntityTest extends TestCase
{
    public function testSupportFloat(): void
    {
        $size = new SizeEntity(200.2, 32.5);
        $this->assertEquals(200.2, $size->width);
        $this->assertEquals(32.5, $size->height);
    }

    public function testSupportInt(): void
    {
        $size = new SizeEntity(200, 32);
        $this->assertEquals(200, $size->width);
        $this->assertEquals(32, $size->height);
    }
}
