<?php

declare(strict_types=1);

namespace LaraStrict\Database\Constants;

enum ModelEvents: string
{
    /**
     * @var string
     */
    public const CREATED = 'created';

    /**
     * @var string
     */
    public const CREATING = 'creating';

    /**
     * @var string
     */
    public const DELETED = 'deleted';

    /**
     * @var string
     */
    public const SAVED = 'saved';

    /**
     * @var string
     */
    public const SAVING = 'saving';

    /**
     * @var string
     */
    public const UPDATED = 'updated';

    /**
     * @var string
     */
    public const RESTORED = 'restored';
}
