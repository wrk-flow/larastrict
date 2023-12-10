<?php

declare(strict_types=1);

namespace LaraStrict\Context\Services;

use Closure;
use Illuminate\Contracts\Container\Container;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Database\Eloquent\Model;
use LaraStrict\Context\Contexts\AbstractContext;
use LaraStrict\Context\Contracts\ContextServiceContract;
use LaraStrict\Context\Contracts\ContextValueContract;

class ContextEventsService
{
    public function __construct(
        private readonly Dispatcher $eventsDispatcher,
        private readonly ContextServiceContract $contextService,
        private readonly Container $container
    ) {
    }

    /**
     * @template TEvent of object
     * @template TContext of AbstractContext
     * @template TContextValue of ContextValueContract
     *
     * @param array<class-string<TEvent>>|class-string<TEvent> $events
     * @param callable(TEvent):(TContext|null)                 $createContext
     * @param callable(TEvent):(TContextValue|null)            $getStateToStore
     */
    public function setOn(array|string $events, callable $createContext, callable $getStateToStore): void
    {
        $this->eventsDispatcher->listen(
            $events,
            function ($event) use ($createContext, $getStateToStore): void {
                $context = $createContext($event);

                if ($context instanceof AbstractContext === false) {
                    return;
                }

                $value = $this->container->call($getStateToStore, [
                    'event' => $event,
                ]);

                if ($value === null) {
                    return;
                }

                $this->contextService->set($context, $value);
            }
        );
    }

    /**
     * @template TEvent of object
     * @template TContext of AbstractContext
     *
     * @param array<class-string<TEvent>>|class-string<TEvent> $events
     * @param callable(TEvent):(TContext|null)                 $createContext
     */
    public function clearOn(string|array $events, callable $createContext): void
    {
        $this->eventsDispatcher->listen($events, function ($event) use ($createContext): void {
            $context = $createContext($event);

            if ($context instanceof AbstractContext === false) {
                return;
            }

            $this->contextService->delete($context);
        });
    }

    /**
     * Clears cache based on the model has given attribute changes and then clear the context cache.
     *
     * @template TEvent of object
     * @template TContext of AbstractContext
     *
     * @param array<class-string<TEvent>>|class-string<TEvent> $events
     * @param array<string>                                    $watchForAttributesChanges Clear if any of given
     * attributes changes
     * @param Closure(TEvent):(Model|null)                     $getModelFromEvent Convert event to model
     * @param callable(TEvent):(TContext|null)                 $createContext
     */
    public function clearOnModelChanges(
        Closure|string|array $events,
        array $watchForAttributesChanges,
        Closure $getModelFromEvent,
        callable $createContext
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

                $context = $createContext($event);

                if ($context instanceof AbstractContext === false) {
                    return;
                }

                $this->contextService->delete($context);
            }
        );
    }
}
