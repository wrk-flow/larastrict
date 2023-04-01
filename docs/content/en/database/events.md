---
title: Events
category: Database
---

> For this example we are working in ObjectProvider domain.

These are best practices and tools for "event" driven business logic.

## Model events

For model changes we are providing small life improvements:

- constants with Laravel event names. See `LaraStrict\Database\Constants\ModelEvents` _at this moment enum can't be used within array as key (in property)_.
- abstract event classes.

### Changed

> Allows serializing model without loosing changes

**First create the event and use `AbstractModelChangedEvent`**

```php

declare(strict_types=1);

namespace App\ObjectProvider\Events;

use LaraStrict\Database\Events\AbstractModelChangedEvent;

class ObjectProviderUpdatedEvent extends AbstractModelChangedEvent
{
    public readonly array $changes;

    public function __construct(public readonly ObjectProvider $provider)
    {
        parent::__construct($provider);
    }
}
```

**Then ensure that event is dispatched when the model has changed**

```php
declare(strict_types=1);

namespace App\ObjectProvider\Listeners;

use LaraStrict\Database\Constants\ModelEvents;
use Illuminate\Database\Eloquent\Model;

class ObjectProvider extends Model {
    protected $dispatchesEvents = [
        ModelEvents::UPDATED => ObjectProviderUpdatedEvent::class,
    ];
}
```

## Listeners

> Listeners are located in your domain within `Listeners` directory.

- It is recommended to use `ShouldQueue` interface on listeners with more demanding logic (or a logic that can be processed with small timeout).
- Do not forget that event with `SerializeModels` in queue will not contain made changes (model is re-fetched from database).
- **It is recommended to log and "exit" states of the listener to make your debugging easier**
- Inject all dependencies in `__constructor`. Use `private readonly` or `protected readonly` for all properties.

### Dispatch events when attribute has changed

Sometimes you want to listen for changes on model and then dispatch concrete events to split the logic in multiple 
listeners.

1. Create a class and extend `LaraStrict\Database\Listeners\AbstractDispatchChangesEventsListener`.
2. Implement `attributesToEvent` that should return an array map of `attribute name` and a `Closure` that tries to create event (can return null).
   1. You will receive the value (do not forget typehint the correct type) as first argument
   2. You will receive the event  (do not forget typehint the correct type) as second argument
   3. Return an `object` or event name `string`
3. (optional) Typehint which model is received for PHPStan
   ```php 
   /**
    * @extends AbstractDispatchChangesEventsListener<ObjectProviderUpdatedEvent>
    */
   class DispatchObjectProviderChangesListener extends AbstractDispatchChangesEventsListener
   ```

```php
declare(strict_types=1);

namespace App\ObjectProvider\Listeners;

use App\ObjectProvider\Models\ObjectProvider;
use App\ObjectProvider\Events\ObjectProviderChannelManagerChangedEvent;
use App\ObjectProvider\Events\ObjectProviderUpdatedEvent;
use LaraStrict\Database\Listeners\AbstractDispatchChangesEventsListener;

/**
 * @extends AbstractDispatchChangesEventsListener<ObjectProviderUpdatedEvent>
 */
class DispatchObjectProviderChangesListener extends AbstractDispatchChangesEventsListener
{
    public function attributesToEvent(): array
    {
        return [
            ObjectProvider::ATTRIBUTE_CHANNEL_MANAGER_ID => function (?int $previousValue, ObjectProviderUpdatedEvent $event) {
                return new ObjectProviderChannelManagerChangedEvent($event->provider->getKey(), $previousValue, $event->provider->channel_manager_id);
            },
        ];
    }
}
```

### Register listener

Create or edit your service provider for your domain. [How to create service providers](../service-provider.md).

```php
<?php

declare(strict_types=1);

namespace App\ObjectProvider;

use App\ObjectProvider\Events\ObjectProviderUpdatedEvent;
use App\ObjectProvider\Listeners\DispatchObjectProviderChangesListener;
use LaraStrict\Providers\AbstractServiceProvider;

class ObjectProviderServiceProvider extends AbstractServiceProvider
{
    protected $listen = [
        ObjectProviderUpdatedEvent::class => [
            DispatchObjectProviderChangesListener::class,
        ],
    ];
}
```

### Logging

> Follow practices defined in [Logging](../logging.md)

```php
<?php

declare(strict_types=1);

namespace App\ChannelManager\Typology\Listeners;

use App\ChannelManager\Typology\Actions\UnPairProviderFromChannelManagerAction;
use App\ObjectProvider\Events\ObjectProviderChannelManagerChangedEvent;
use Illuminate\Contracts\Queue\ShouldQueue;
use Psr\Log\LoggerInterface;

/**
 * Listens for ObjectProviderChannelManagerChangedEvent (channel_manager_id has changed) and
 * removes object_type_id for all typologies of previous channel manager that is owned
 * by the provider.
 * 1. Get object types for the provider (in chunk)
 * 2. Set object_type_id to null for the chunk of object type ids for previous channel manager.
 */
class DiscardObjectTypePairOnProviderChangeListener implements ShouldQueue
{
    public function __construct(
        private readonly LoggerInterface $logger,
        private readonly UnPairProviderFromChannelManagerAction $unPairProviderFromChannelManagerAction
    ) {
    }

    public function handle(ObjectProviderChannelManagerChangedEvent $event): void
    {
        $channelManagerId = $event->from;
        $context = [
            'from_channel_manager_id' => $channelManagerId,
            'to_channel_manager_id' => $event->to,
            'provider_id' => $event->providerId,
        ];

        if ($channelManagerId === null) {
            $this->logger->debug('Typology pairing to object is not needed - channel manager was not', $context);

            return;
        }

        $this->logger->debug('Discarding typology pairing for a provider', $context);

        $this->unPairProviderFromChannelManagerAction->execute($channelManagerId, $event->providerId);
    }
}
```
