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
     * @param array<GateHasExpectation|null> $has
     * @param array<GateDefineExpectation|null> $define
     * @param array<GateResourceExpectation|null> $resource
     * @param array<GatePolicyExpectation|null> $policy
     * @param array<GateBeforeExpectation|null> $before
     * @param array<GateAfterExpectation|null> $after
     * @param array<GateAllowsExpectation|null> $allows
     * @param array<GateDeniesExpectation|null> $denies
     * @param array<GateCheckExpectation|null> $check
     * @param array<GateAnyExpectation|null> $any
     * @param array<GateAuthorizeExpectation|null> $authorize
     * @param array<GateInspectExpectation|null> $inspect
     * @param array<GateRawExpectation|null> $raw
     * @param array<GateGetPolicyForExpectation|null> $getPolicyFor
     * @param array<GateForUserExpectation|null> $forUser
     * @param array<GateAbilitiesExpectation|null> $abilities
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
        parent::__construct();
        $this->setExpectations(GateHasExpectation::class, $has);
        $this->setExpectations(GateDefineExpectation::class, $define);
        $this->setExpectations(GateResourceExpectation::class, $resource);
        $this->setExpectations(GatePolicyExpectation::class, $policy);
        $this->setExpectations(GateBeforeExpectation::class, $before);
        $this->setExpectations(GateAfterExpectation::class, $after);
        $this->setExpectations(GateAllowsExpectation::class, $allows);
        $this->setExpectations(GateDeniesExpectation::class, $denies);
        $this->setExpectations(GateCheckExpectation::class, $check);
        $this->setExpectations(GateAnyExpectation::class, $any);
        $this->setExpectations(GateAuthorizeExpectation::class, $authorize);
        $this->setExpectations(GateInspectExpectation::class, $inspect);
        $this->setExpectations(GateRawExpectation::class, $raw);
        $this->setExpectations(GateGetPolicyForExpectation::class, $getPolicyFor);
        $this->setExpectations(GateForUserExpectation::class, $forUser);
        $this->setExpectations(GateAbilitiesExpectation::class, $abilities);
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

        if ($expectation->return instanceof Response === false) {
            $response = new Response($expectation->return);
        } else {
            $response = $expectation->return;
        }

        // Run authorize() method to force exception
        $response->authorize();

        return $response;
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
