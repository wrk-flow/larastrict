<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Pipes;

use Closure;
use Illuminate\Contracts\Auth\Access\Gate;
use LaraStrict\Contracts\AppServiceProviderPipeContract;
use LaraStrict\Contracts\HasPolicies;
use LaraStrict\Entities\AppServiceProviderEntity;

class RegisterProviderPoliciesPipe implements AppServiceProviderPipeContract
{
    public function __construct(
        private readonly Gate $gate
    ) {
    }

    public function handle(AppServiceProviderEntity $appServiceProvider, Closure $next): void
    {
        if ($appServiceProvider->serviceProvider instanceof HasPolicies) {
            foreach ($appServiceProvider->serviceProvider->policies() as $class => $policy) {
                $this->gate->policy($class, $policy);
            }
        }

        $next($appServiceProvider);
    }
}
