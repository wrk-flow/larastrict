<?php declare(strict_types=1);

namespace LaraStrict\Testing\Actions;

use LaraStrict\Testing\Entities\PhpDocEntity;
use LaraStrict\Testing\Enums\PhpType;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Factory;
use ReflectionMethod;
use ReflectionNamedType;
use ReflectionUnionType;

final class ExpectationMethodAssertAction
{
    /**
     * Generates a method assert in assert class. Generates __construct if $expectationClassName is passed (requires
     * extending AbstractExpectationCallsMap).
     */
    public function execute(
        ClassType $assertClass,
        ReflectionMethod $method,
        string $expectationClassName,
        PhpDocEntity $phpDoc,
    ): void
    {
        $parameters = $method->getParameters();

        $assertMethod = (new Factory())->fromMethodReflection($method);
        $assertClass->addMember($assertMethod);

        $assertMethod->addBody(sprintf(
            '$_expectation = $this->getExpectation(%s);',
            $expectationClassName . '::class'
        ));

        $hookParameters = [];

        if ($parameters !== []) {
            $assertMethod->addBody('$_message = $this->getDebugMessage();');
            $assertMethod->addBody('');

            foreach ($parameters as $parameter) {
                $hookParameters[] = sprintf('$%s', $parameter->name);
                $assertMethod->addBody(sprintf(
                    'Assert::assertEquals($_expectation->%s, $%s, $_message);',
                    $parameter->name,
                    $parameter->name
                ));
            }
        }

        $hookParameters[] = '$_expectation';

        $assertMethod->addBody('');

        $assertMethod->addBody(sprintf('if (is_callable($_expectation->%s)) {', ExpectationFileContentAction::HookProperty));
        $assertMethod->addBody(sprintf(
            '    call_user_func($_expectation->%s, %s);',
            ExpectationFileContentAction::HookProperty,
            implode(', ', $hookParameters),
        ));
        $assertMethod->addBody('}');

        $returnType = $method->getReturnType();

        if ($returnType instanceof ReflectionNamedType) {
            $enumReturnType = PhpType::tryFrom($returnType->getName()) ?? PhpType::Mixed;
        } elseif ($returnType instanceof ReflectionUnionType) {
            $enumReturnType = PhpType::Mixed;
        } else {
            $enumReturnType = $phpDoc->returnType;
        }

        switch ($enumReturnType) {
            case PhpType::Mixed:
                $assertMethod->addBody('');
                $assertMethod->addBody('return $_expectation->return;');
                break;
            case PhpType::Self:
            case PhpType::Static:
                $assertMethod->addBody('');
                $assertMethod->addBody('return $this;');
                break;
        }
    }
}
