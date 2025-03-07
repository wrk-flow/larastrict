<?php declare(strict_types=1);

namespace LaraStrict\Testing\Actions;

use LaraStrict\Testing\Assert\AbstractExpectationCallsMap;
use LaraStrict\Testing\Entities\AssertFileStateEntity;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;
use PHPUnit\Framework\Assert;
use ReflectionClass;

final class GenerateAssertClassAction
{
    /**
     * @param ReflectionClass<object> $class
     */
    public function execute(
        ReflectionClass $class,
        string $namespace,
    ): AssertFileStateEntity
    {
        $file = new PhpFile();
        $file->setStrictTypes();

        $assertNamespace = $file->addNamespace($namespace);
        $assertNamespace->addUse(Assert::class);

        $assertClass = $assertNamespace->addClass($class->getShortName() . 'Assert');
        $assertClass->addImplement($class->getName());

        $assertConstructor = new Method('__construct');
        $assertClass->setExtends(AbstractExpectationCallsMap::class);
        $assertClass->addMember($assertConstructor);

        $assertConstructor->addBody('parent::__construct();');

        return new AssertFileStateEntity($file, $assertClass, $assertConstructor);
    }
}
