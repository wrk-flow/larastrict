<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Laravel\Contracts\Auth\Access;

use PHPUnit\Framework\Assert;

class GateAssert extends \LaraStrict\Testing\AbstractExpectationCallsMap implements \Illuminate\Contracts\Auth\Access\Gate
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
    function __construct(
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
        $this->setExpectations('has', array_values(array_filter($has)));
        $this->setExpectations('define', array_values(array_filter($define)));
        $this->setExpectations('resource', array_values(array_filter($resource)));
        $this->setExpectations('policy', array_values(array_filter($policy)));
        $this->setExpectations('before', array_values(array_filter($before)));
        $this->setExpectations('after', array_values(array_filter($after)));
        $this->setExpectations('allows', array_values(array_filter($allows)));
        $this->setExpectations('denies', array_values(array_filter($denies)));
        $this->setExpectations('check', array_values(array_filter($check)));
        $this->setExpectations('any', array_values(array_filter($any)));
        $this->setExpectations('authorize', array_values(array_filter($authorize)));
        $this->setExpectations('inspect', array_values(array_filter($inspect)));
        $this->setExpectations('raw', array_values(array_filter($raw)));
        $this->setExpectations('getPolicyFor', array_values(array_filter($getPolicyFor)));
        $this->setExpectations('forUser', array_values(array_filter($forUser)));
        $this->setExpectations('abilities', array_values(array_filter($abilities)));
    }

    /**
     * Determine if a given ability has been defined.
     *
     * @param  string  $ability
     * @return bool
     */
    function has($ability)
    {
        /** @var GateHasExpectation $expectation */
        $expectation = $this->getExpectation('has');
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
    function define($ability, $callback)
    {
        /** @var GateDefineExpectation $expectation */
        $expectation = $this->getExpectation('define');
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
     * @param  array|null  $abilities
     * @return $this
     */
    function resource($name, $class, array $abilities = null)
    {
        /** @var GateResourceExpectation $expectation */
        $expectation = $this->getExpectation('resource');
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
    function policy($class, $policy)
    {
        /** @var GatePolicyExpectation $expectation */
        $expectation = $this->getExpectation('policy');
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->class, $class, $message);
        Assert::assertEquals($expectation->policy, $policy, $message);

        return $this;
    }

    /**
     * Register a callback to run before all Gate checks.
     *
     * @param  callable  $callback
     * @return $this
     */
    function before(callable $callback)
    {
        /** @var GateBeforeExpectation $expectation */
        $expectation = $this->getExpectation('before');
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->callback, $callback, $message);

        return $this;
    }

    /**
     * Register a callback to run after all Gate checks.
     *
     * @param  callable  $callback
     * @return $this
     */
    function after(callable $callback)
    {
        /** @var GateAfterExpectation $expectation */
        $expectation = $this->getExpectation('after');
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
    function allows($ability, $arguments = [])
    {
        /** @var GateAllowsExpectation $expectation */
        $expectation = $this->getExpectation('allows');
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
    function denies($ability, $arguments = [])
    {
        /** @var GateDeniesExpectation $expectation */
        $expectation = $this->getExpectation('denies');
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
    function check($abilities, $arguments = [])
    {
        /** @var GateCheckExpectation $expectation */
        $expectation = $this->getExpectation('check');
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
    function any($abilities, $arguments = [])
    {
        /** @var GateAnyExpectation $expectation */
        $expectation = $this->getExpectation('any');
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
     * @return \Illuminate\Auth\Access\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    function authorize($ability, $arguments = [])
    {
        /** @var GateAuthorizeExpectation $expectation */
        $expectation = $this->getExpectation('authorize');
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
     * @return \Illuminate\Auth\Access\Response
     */
    function inspect($ability, $arguments = [])
    {
        /** @var GateInspectExpectation $expectation */
        $expectation = $this->getExpectation('inspect');
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
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    function raw($ability, $arguments = [])
    {
        /** @var GateRawExpectation $expectation */
        $expectation = $this->getExpectation('raw');
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
     *
     * @throws \InvalidArgumentException
     */
    function getPolicyFor($class)
    {
        /** @var GateGetPolicyForExpectation $expectation */
        $expectation = $this->getExpectation('getPolicyFor');
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->class, $class, $message);

        return $expectation->return;
    }

    /**
     * Get a guard instance for the given user.
     *
     * @param  \Illuminate\Contracts\Auth\Authenticatable|mixed  $user
     * @return static
     */
    function forUser($user)
    {
        /** @var GateForUserExpectation $expectation */
        $expectation = $this->getExpectation('forUser');
        $message = $this->getDebugMessage();

        Assert::assertEquals($expectation->user, $user, $message);

        return $this;
    }

    /**
     * Get all of the defined abilities.
     *
     * @return array
     */
    function abilities()
    {
        /** @var GateAbilitiesExpectation $expectation */
        $expectation = $this->getExpectation('abilities');

        return $expectation->return;
    }
}
