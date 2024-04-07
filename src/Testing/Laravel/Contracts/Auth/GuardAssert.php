<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Guard;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class GuardAssert extends AbstractExpectationCallsMap implements Guard
{
    /**
     * @param array<GuardCheckExpectation|null> $check
     * @param array<GuardGuestExpectation|null> $guest
     * @param array<GuardUserExpectation|null> $user
     * @param array<GuardIdExpectation|null> $id
     * @param array<GuardValidateExpectation|null> $validate
     * @param array<GuardHasUserExpectation|null> $hasUser
     * @param array<GuardSetUserExpectation|null> $setUser
     */
    public function __construct(
        array $check = [],
        array $guest = [],
        array $user = [],
        array $id = [],
        array $validate = [],
        array $hasUser = [],
        array $setUser = [],
    ) {
        parent::__construct();
        $this->setExpectations(GuardCheckExpectation::class, $check);
        $this->setExpectations(GuardGuestExpectation::class, $guest);
        $this->setExpectations(GuardUserExpectation::class, $user);
        $this->setExpectations(GuardIdExpectation::class, $id);
        $this->setExpectations(GuardValidateExpectation::class, $validate);
        $this->setExpectations(GuardHasUserExpectation::class, $hasUser);
        $this->setExpectations(GuardSetUserExpectation::class, $setUser);
    }

    /**
     * Determine if the current user is authenticated.
     *
     * @return bool
     */
    public function check()
    {
        $expectation = $this->getExpectation(GuardCheckExpectation::class);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Determine if the current user is a guest.
     *
     * @return bool
     */
    public function guest()
    {
        $expectation = $this->getExpectation(GuardGuestExpectation::class);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return Authenticatable|null
     */
    public function user()
    {
        $expectation = $this->getExpectation(GuardUserExpectation::class);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Get the ID for the currently authenticated user.
     *
     * @return int|string|null
     */
    public function id()
    {
        $expectation = $this->getExpectation(GuardIdExpectation::class);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Validate a user's credentials.
     *
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        $expectation = $this->getExpectation(GuardValidateExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->credentials, $credentials, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $credentials, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Determine if the guard has a user instance.
     *
     * @return bool
     */
    public function hasUser()
    {
        $expectation = $this->getExpectation(GuardHasUserExpectation::class);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $expectation);
        }

        return $expectation->return;
    }

    /**
     * Set the current user.
     *
     * @todo remove typehint (Remove when dropping support for Laravel 10)
     * @return self
     */
    public function setUser(Authenticatable $user)
    {
        $expectation = $this->getExpectation(GuardSetUserExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->user, $user, $message);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $user, $expectation);
        }

        return $this;
    }
}
