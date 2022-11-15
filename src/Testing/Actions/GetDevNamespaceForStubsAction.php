<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Actions;

use Illuminate\Console\Command;
use LaraStrict\Testing\Constants\StubConstants;
use LaraStrict\Testing\Contracts\GetNamespaceForStubsActionContract;
use LaraStrict\Testing\Entities\NamespaceEntity;

class GetDevNamespaceForStubsAction implements GetNamespaceForStubsActionContract
{
    public function execute(Command $command, string $basePath, string $inputClass): NamespaceEntity
    {
        // We want to place Laravel assert / expectations to Laravel Folder.

        $subFolder = str_starts_with($inputClass, 'Illuminate' . StubConstants::NameSpaceSeparator) ? 'Laravel' : null;
        return new NamespaceEntity(
            implode(DIRECTORY_SEPARATOR, array_filter(['src', 'Testing', $subFolder])) . DIRECTORY_SEPARATOR,
            implode(StubConstants::NameSpaceSeparator, array_filter([
                'LaraStrict',
                'Testing',
                $subFolder,
            ])) . StubConstants::NameSpaceSeparator
        );
    }
}
