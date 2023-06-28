<?php

declare(strict_types=1);

namespace LaraStrict\Testing\PHPUnit\Traits;

use Illuminate\Database\ConnectionResolverInterface;
use Illuminate\Database\Eloquent\Model;
use Mockery;

trait MockModels
{
    public function mockModels(): void
    {
        // Resolve connection for all models
        $resolver = Mockery::mock(ConnectionResolverInterface::class);
        $resolver->shouldReceive('connection->getQueryGrammar->getDateFormat')
            ->andReturn('Y-m-d H:i:s');

        Model::setConnectionResolver($resolver);
    }
}
