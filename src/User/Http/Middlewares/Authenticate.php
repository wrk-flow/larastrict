<?php

declare(strict_types=1);

namespace LaraStrict\User\Http\Middlewares;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Request;
use LaraStrict\Enums\EnvironmentType;
use LaraStrict\User\Contracts\GetUserForAutoLoginActionContract;

class Authenticate extends Middleware
{
    public function __construct(
        Auth $auth,
        private readonly Application $application,
        private readonly GetUserForAutoLoginActionContract $getUserForAutoLoginActionContract,
    ) {
        parent::__construct($auth);
    }

    protected function authenticate($request, array $guards): void
    {
        if (empty($guards)) {
            $guards = [null];
        }

        $this->autoLoginFirstUserOnLocalIfNeeded($request, $guards);

        parent::authenticate($request, $guards);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     *
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if ($request->expectsJson() === false) {
            return route('login');
        }
    }

    protected function autoLoginFirstUserOnLocalIfNeeded(Request $request, array $guards): void
    {
        $autoLogin = $request->header('Auto-Login');
        if ($this->application->environment([EnvironmentType::Local->value]) === false ||
            $autoLogin === null) {
            return;
        }

        foreach ($guards as $guard) {
            $guardInstance = $this->auth->guard($guard);

            if ($guardInstance->check()) {
                break;
            }

            $user = $this->getUserForAutoLoginActionContract->execute($autoLogin);

            if ($user !== null) {
                $guardInstance->setUser($user);
            }

            break;
        }
    }
}
