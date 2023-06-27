<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Config\Contracts;

use LaraStrict\Config\Contracts\AppConfigContract;
use LaraStrict\Enums\EnvironmentType;
use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;

class AppConfigContractAssert extends AbstractExpectationCallsMap implements AppConfigContract
{
    /**
     * @param array<AppConfigContractGetVersionExpectation|null> $getVersion
     * @param array<AppConfigContractGetKeyExpectation|null> $getKey
     * @param array<AppConfigContractGetUrlExpectation|null> $getUrl
     * @param array<AppConfigContractGetAssetUrlExpectation|null> $getAssetUrl
     * @param array<AppConfigContractGetNameExpectation|null> $getName
     * @param array<AppConfigContractIsInDebugModeExpectation|null> $isInDebugMode
     * @param array<AppConfigContractGetEnvironmentExpectation|null> $getEnvironment
     */
    public function __construct(
        array $getVersion = [],
        array $getKey = [],
        array $getUrl = [],
        array $getAssetUrl = [],
        array $getName = [],
        array $isInDebugMode = [],
        array $getEnvironment = [],
    ) {
        parent::__construct();
        $this->setExpectations(AppConfigContractGetVersionExpectation::class, $getVersion);
        $this->setExpectations(AppConfigContractGetKeyExpectation::class, $getKey);
        $this->setExpectations(AppConfigContractGetUrlExpectation::class, $getUrl);
        $this->setExpectations(AppConfigContractGetAssetUrlExpectation::class, $getAssetUrl);
        $this->setExpectations(AppConfigContractGetNameExpectation::class, $getName);
        $this->setExpectations(AppConfigContractIsInDebugModeExpectation::class, $isInDebugMode);
        $this->setExpectations(AppConfigContractGetEnvironmentExpectation::class, $getEnvironment);
    }

    /**
     * Version from an app (Larastrict projects uses app.version).
     */
    public function getVersion(): string
    {
        $expectation = $this->getExpectation(AppConfigContractGetVersionExpectation::class);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $expectation);
        }

        return $expectation->return;
    }

    public function getKey(): string
    {
        $expectation = $this->getExpectation(AppConfigContractGetKeyExpectation::class);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $expectation);
        }

        return $expectation->return;
    }

    public function getUrl(): string
    {
        $expectation = $this->getExpectation(AppConfigContractGetUrlExpectation::class);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $expectation);
        }

        return $expectation->return;
    }

    public function getAssetUrl(): ?string
    {
        $expectation = $this->getExpectation(AppConfigContractGetAssetUrlExpectation::class);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $expectation);
        }

        return $expectation->return;
    }

    public function getName(): string
    {
        $expectation = $this->getExpectation(AppConfigContractGetNameExpectation::class);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $expectation);
        }

        return $expectation->return;
    }

    public function isInDebugMode(): bool
    {
        $expectation = $this->getExpectation(AppConfigContractIsInDebugModeExpectation::class);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $expectation);
        }

        return $expectation->return;
    }

    public function getEnvironment(): EnvironmentType|string
    {
        $expectation = $this->getExpectation(AppConfigContractGetEnvironmentExpectation::class);

        if (is_callable($expectation->hook)) {
            call_user_func($expectation->hook, $expectation);
        }

        return $expectation->return;
    }
}
