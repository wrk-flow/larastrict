<?php

declare(strict_types=1);

namespace LaraStrict\Database\Constants;

enum ModelEvents: string
{
    public const CREATED = 'created';

    public const CREATING = 'creating';

    public const DELETED = 'deleted';

    public const SAVED = 'saved';

    public const SAVING = 'saving';

    public const UPDATED = 'updated';

    public const RESTORED = 'restored';
}
