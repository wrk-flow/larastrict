<?php

declare(strict_types=1);

namespace LaraStrict\Database\Events;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Queue\SerializesModels;

/**
 * Allows serializing model without loosing changed values.
 */
abstract class AbstractModelChangedEvent
{
    use SerializesModels;

    /**
     * Contains model changes the new values.
     *
     * @var array<string, array>
     */
    public readonly array $changes;

    /**
     * Contains model changes the old values.
     *
     * @var array<string, array>
     */
    public readonly array $changesOriginalValues;

    public function __construct(Model $model)
    {
        $this->changes = $model->getChanges();

        $originalValues = [];

        foreach (array_keys($this->changes) as $attribute) {
            $originalValues[$attribute] = $model->getOriginal($attribute);
        }

        $this->changesOriginalValues = $originalValues;
    }
}
