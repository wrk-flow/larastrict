<?php

declare(strict_types=1);

namespace LaraStrict\Providers\Pipes;

use Closure;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use LaraStrict\Contracts\AppServiceProviderPipeContract;
use LaraStrict\Entities\AppServiceProviderEntity;

/**
 * We want to place factories in same folder as the model.
 */
class SetFactoryResolvingProviderPipe implements AppServiceProviderPipeContract
{
    public function handle(AppServiceProviderEntity $appServiceProvider, Closure $next): void
    {
        Factory::guessFactoryNamesUsing(static function (string $class) {
            /** @var class-string<Factory<Model>> $factoryClass */
            $factoryClass = $class . 'Factory';
            return $factoryClass;
        });

        Factory::guessModelNamesUsing(static function (Factory $factory) {
            /** @var class-string<Model> $class */
            $class = Str::replaceLast('Factory', '', $factory::class);
            return $class;
        });

        $next($appServiceProvider);
    }
}
