<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Auth\Access\Gate;
use Illuminate\Contracts\Auth\Authenticatable;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use PHPUnit\Framework\Assert;

class GateAssert extends AbstractExpectationCallsMap implements Gate
{
    /**
     * @param array<GateHasExpectation> $has
     * @param array<GateDefineExpectation> $define
     * @param array<GateResourceExpectation> $resource
     * @param array<GatePolicyExpectation> $policy
     * @param array<GateBeforeExpectation> $before
     * @param array<GateAfterExpectation> $after
     * @param array<GateAllowsExpectation> $allows
     * @param array<GateDeniesExpectation> $denies
     * @param array<GateCheckExpectation> $check
     * @param array<GateAnyExpectation> $any
     * @param array<GateAuthorizeExpectation> $authorize
     * @param array<GateInspectExpectation> $inspect
     * @param array<GateRawExpectation> $raw
     * @param array<GateGetPolicyForExpectation> $getPolicyFor
     * @param array<GateForUserExpectation> $forUser
     * @param array<GateAbilitiesExpectation> $abilities
     */
    public function __construct(
        array $has = [],
        array $define = [],
        array $resource = [],
        array $policy = [],
        array $before = [],
        array $after = [],
        array $allows = [],
        array $denies = [],
        array $check = [],
        array $any = [],
        array $authorize = [],
        array $inspect = [],
        array $raw = [],
        array $getPolicyFor = [],
        array $forUser = [],
        array $abilities = [],
    ) {
        $this->setExpectations(GateHasExpectation::class, array_values(array_filter($has)));
        $this->setExpectations(GateDefineExpectation::class, array_values(array_filter($define)));
        $this->setExpectations(GateResourceExpectation::class, array_values(array_filter($resource)));
        $this->setExpectations(GatePolicyExpectation::class, array_values(array_filter($policy)));
        $this->setExpectations(GateBeforeExpectation::class, array_values(array_filter($before)));
        $this->setExpectations(GateAfterExpectation::class, array_values(array_filter($after)));
        $this->setExpectations(GateAllowsExpectation::class, array_values(array_filter($allows)));
        $this->setExpectations(GateDeniesExpectation::class, array_values(array_filter($denies)));
        $this->setExpectations(GateCheckExpectation::class, array_values(array_filter($check)));
        $this->setExpectations(GateAnyExpectation::class, array_values(array_filter($any)));
        $this->setExpectations(GateAuthorizeExpectation::class, array_values(array_filter($authorize)));
        $this->setExpectations(GateInspectExpectation::class, array_values(array_filter($inspect)));
        $this->setExpectations(GateRawExpectation::class, array_values(array_filter($raw)));
        $this->setExpectations(GateGetPolicyForExpectation::class, array_values(array_filter($getPolicyFor)));
        $this->setExpectations(GateForUserExpectation::class, array_values(array_filter($forUser)));
        $this->setExpectations(GateAbilitiesExpectation::class, array_values(array_filter($abilities)));
    }

    /**
     * Determine if a given ability has been defined.
     *
     * @param  string  $ability
     * @return bool
     */
    public function has($ability)
    {
        $expectation = $this->getExpectation(GateHasExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->ability, $ability, $message);

        return $expectation->return;
    }

    /**
     * Define a new ability.
     *
     * @param  string  $ability
     * @param  callable|string  $callback
     * @return $this
     */
    public function define($ability, $callback)
    {
        $expectation = $this->getExpectation(GateDefineExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->ability, $ability, $message);
        Assert::assertEquals($expectation->callback, $callback, $message);

        return $this;
    }

    /**
     * Define abilities for a resource.
     *
     * @param  string  $name
     * @param  string  $class
     * @return $this
     */
    public function resource($name, $class, array $abilities = null)
    {
        $expectation = $this->getExpectation(GateResourceExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->name, $name, $message);
        Assert::assertEquals($expectation->class, $class, $message);
        Assert::assertEquals($expectation->abilities, $abilities, $message);

        return $this;
    }

    /**
     * Define a policy class for a given class type.
     *
     * @param  string  $class
     * @param  string  $policy
     * @return $this
     */
    public function policy($class, $policy)
    {
        $expectation = $this->getExpectation(GatePolicyExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->class, $class, $message);
        Assert::assertEquals($expectation->policy, $policy, $message);

        return $this;
    }

    /**
     * Register a callback to run before all Gate checks.
     *
     * @return $this
     */
    public function before(callable $callback)
    {
        $expectation = $this->getExpectation(GateBeforeExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->callback, $callback, $message);

        return $this;
    }

    /**
     * Register a callback to run after all Gate checks.
     *
     * @return $this
     */
    public function after(callable $callback)
    {
        $expectation = $this->getExpectation(GateAfterExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->callback, $callback, $message);

        return $this;
    }

    /**
     * Determine if the given ability should be granted for the current user.
     *
     * @param  string  $ability
     * @param  array|mixed  $arguments
     * @return bool
     */
    public function allows($ability, $arguments = [])
    {
        $expectation = $this->getExpectation(GateAllowsExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->ability, $ability, $message);
        Assert::assertEquals($expectation->arguments, $arguments, $message);

        return $expectation->return;
    }

    /**
     * Determine if the given ability should be denied for the current user.
     *
     * @param  string  $ability
     * @param  array|mixed  $arguments
     * @return bool
     */
    public function denies($ability, $arguments = [])
    {
        $expectation = $this->getExpectation(GateDeniesExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->ability, $ability, $message);
        Assert::assertEquals($expectation->arguments, $arguments, $message);

        return $expectation->return;
    }

    /**
     * Determine if all of the given abilities should be granted for the current user.
     *
     * @param  iterable|string  $abilities
     * @param  array|mixed  $arguments
     * @return bool
     */
    public function check($abilities, $arguments = [])
    {
        $expectation = $this->getExpectation(GateCheckExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abilities, $abilities, $message);
        Assert::assertEquals($expectation->arguments, $arguments, $message);

        return $expectation->return;
    }

    /**
     * Determine if any one of the given abilities should be granted for the current user.
     *
     * @param  iterable|string  $abilities
     * @param  array|mixed  $arguments
     * @return bool
     */
    public function any($abilities, $arguments = [])
    {
        $expectation = $this->getExpectation(GateAnyExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->abilities, $abilities, $message);
        Assert::assertEquals($expectation->arguments, $arguments, $message);

        return $expectation->return;
    }

    /**
     * Determine if the given ability should be granted for the current user.
     *
     * @param  string  $ability
     * @param  array|mixed  $arguments
     * @return Response
     */
    public function authorize($ability, $arguments = [])
    {
        $expectation = $this->getExpectation(GateAuthorizeExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->ability, $ability, $message);
        Assert::assertEquals($expectation->arguments, $arguments, $message);

        return $expectation->return;
    }

    /**
     * Inspect the user for the given ability.
     *
     * @param  string  $ability
     * @param  array|mixed  $arguments
     * @return Response
     */
    public function inspect($ability, $arguments = [])
    {
        $expectation = $this->getExpectation(GateInspectExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->ability, $ability, $message);
        Assert::assertEquals($expectation->arguments, $arguments, $message);

        return $expectation->return;
    }

    /**
     * Get the raw result from the authorization callback.
     *
     * @param  string  $ability
     * @param  array|mixed  $arguments
     * @return mixed
     */
    public function raw($ability, $arguments = [])
    {
        $expectation = $this->getExpectation(GateRawExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->ability, $ability, $message);
        Assert::assertEquals($expectation->arguments, $arguments, $message);

        return $expectation->return;
    }

    /**
     * Get a policy instance for a given class.
     *
     * @param  object|string  $class
     * @return mixed
     */
    public function getPolicyFor($class)
    {
        $expectation = $this->getExpectation(GateGetPolicyForExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->class, $class, $message);

        return $expectation->return;
    }

    /**
     * Get a guard instance for the given user.
     *
     * @param Authenticatable|mixed $user
     * @return static
     */
    public function forUser($user)
    {
        $expectation = $this->getExpectation(GateForUserExpectation::class);
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->user, $user, $message);

        return $this;
    }

    /**
     * Get all of the defined abilities.
     *
     * @return array
     */
    public function abilities()
    {
        $expectation = $this->getExpectation(GateAbilitiesExpectation::class);

        return $expectation->return;
    }
}
