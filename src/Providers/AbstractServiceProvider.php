<?php

declare(strict_types=1);

namespace LaraStrict\Providers;

use Closure;
use Illuminate\Contracts\Container\Container;
use LaraStrict\Cache\Contracts\BootContexts;
use LaraStrict\Console\Contracts\HasSchedule;
use LaraStrict\Console\Contracts\HasScheduleOnEnvironments;
use LaraStrict\Console\Contracts\HasScheduleOnProduction;
use LaraStrict\Console\Contracts\ScheduleServiceContract;
use LaraStrict\Context\Contexts\AbstractContext;
use LaraStrict\Context\Services\ContextEventsService;
use LaraStrict\Enums\EnvironmentType;
use LaraStrict\Providers\Pipes\BootProviderPoliciesPipe;
use LaraStrict\Providers\Pipes\BootProviderRoutesPipe;
use LaraStrict\Providers\Pipes\BootProviderViewComponents;
use LaraStrict\Providers\Pipes\BootViewComposersPipe;
use LaraStrict\Providers\Pipes\LoadProviderConfig;
use LaraStrict\Providers\Pipes\LoadProviderTranslations;
use LaraStrict\Providers\Pipes\LoadProviderViews;
use LogicException;

abstract class AbstractServiceProvider extends AbstractBaseServiceProvider
{
    public function register(): void
    {
        parent::register();

        // TODO move to pipe
        if ($this->app->runningInConsole() && $this->canRegisterSchedule()) {
            $this->app->booted(function (): void {
                $schedule = $this->app->make(ScheduleServiceContract::class);

                /** @var HasSchedule $this */
                $this->schedule($schedule);
            });
        }
    }

    public function boot(): void
    {
        parent::boot();

        // TODO move to pipe
        if ($this instanceof BootContexts) {
            $this->bootContexts($this->contexts());
        }
    }

    protected function registerPipes(): array
    {
        return [LoadProviderViews::class, LoadProviderTranslations::class, LoadProviderConfig::class];
    }

    protected function bootPipes(): array
    {
        return [
            BootProviderRoutesPipe::class,
            BootProviderPoliciesPipe::class,
            BootProviderViewComponents::class,
            BootViewComposersPipe::class,
        ];
    }

    protected function canRegisterSchedule(): bool
    {
        if ($this instanceof HasScheduleOnEnvironments) {
            return (bool) $this->app->environment($this->scheduleEnvironments());
        }

        if ($this instanceof HasScheduleOnProduction) {
            return (bool) $this->app->environment([EnvironmentType::Production->value]);
        }

        return $this instanceof HasSchedule;
    }

    /**
     * Ensures that contextual binding in container will get tagged implementation of given interface.
     *
     * @template TImplementation of object
     * @param class-string<TImplementation> $class
     * @return Closure(Container $container):array<TImplementation>
     */
    protected function giveTaggedImplementation(string $class): Closure
    {
        return static function (Container $container) use ($class) {
            $taggedServices = $container->tagged($class);
            $services = [];
            foreach ($taggedServices as $service) {
                if ($service instanceof $class === false) {
                    throw new LogicException(sprintf(
                        'Tagged implementation for %s must be instance of %s',
                        $service::class,
                        $class,
                    ));
                }

                $services[] = $service;
            }
            return $services;
        };
    }

    /**
     * @param array<class-string<AbstractContext>> $contextClasses
     */
    private function bootContexts(array $contextClasses): void
    {
        if ($contextClasses === []) {
            return;
        }

        $service = $this->app->make(ContextEventsService::class);
        assert($service instanceof ContextEventsService);

        foreach ($contextClasses as $context) {
            $context::boot($service);
        }
    }
}
