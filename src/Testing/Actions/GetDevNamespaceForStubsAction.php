<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Actions;

use Illuminate\Console\Command;
use LaraStrict\Testing\Constants\StubConstants;
use LaraStrict\Testing\Contracts\GetNamespaceForStubsActionContract;
use LaraStrict\Testing\Entities\NamespaceEntity;

class GetDevNamespaceForStubsAction implements GetNamespaceForStubsActionContract
{
    public function execute(Command $command, string $basePath): NamespaceEntity
    {
        return new NamespaceEntity(
            'src' . DIRECTORY_SEPARATOR . 'Testing' . DIRECTORY_SEPARATOR,
            implode(StubConstants::NameSpaceSeparator, [
                'LaraStrict',
                'Testing',
            ]) . StubConstants::NameSpaceSeparator
        );
    }
}
