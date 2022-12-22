<?php

declare(strict_types=1);

namespace LaraStrict\Context\Services;

use Closure;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Model;
use LaraStrict\Context\Contexts\AbstractContext;
use LaraStrict\Context\Contracts\ContextServiceContract;

class ContextEventsService
{
    public function __construct(
        private readonly Dispatcher $eventsDispatcher,
        private readonly ContextServiceContract $contextService,
        private readonly Container $container
    ) {
    }

    public function setOn(Closure|string|array $events, callable $createContext, callable $getStateToStore): void
    {
        $this->eventsDispatcher->listen(
            $events,
            function ($event) use ($createContext, $getStateToStore): void {
                $context = $createContext($event);

                if ($context === null) {
                    return;
                }

                $value = $this->container->call($getStateToStore, [
                    'event' => $event,
                ]);
                $this->contextService->set($context, $value);
            }
        );
    }

    public function clearOn(Closure|string|array $events, callable $createContext): void
    {
        $this->eventsDispatcher->listen($events, function ($event) use ($createContext): void {
            $context = $createContext($event);

            if ($context === null) {
                return;
            }

            $this->contextService->delete($context);
        });
    }

    /**
     * Clears cache based on the model has given attribute changes and then clear the context cache.
     *
     * @param array<string>                   $watchForAttributesChanges Clear if any of given attributes changes
     * @param Closure(object):?Model          $getModelFromEvent         Convert event to model
     * @param Closure(object):AbstractContext $createContext             Convert event to context
     */
    public function clearOnModelChanges(
        Closure|string|array $events,
        array $watchForAttributesChanges,
        Closure $getModelFromEvent,
        Closure $createContext
    ): void {
        $this->eventsDispatcher->listen(
            $events,
            function ($event) use ($createContext, $getModelFromEvent, $watchForAttributesChanges): void {
                $model = $getModelFromEvent($event);
                if ($model instanceof Model === false) {
                    return;
                }

                if ($model->wasChanged($watchForAttributesChanges) === false) {
                    return;
                }

                $this->contextService->delete($createContext($event));
            }
        );
    }
}
