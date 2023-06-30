<?php

declare(strict_types=1);

use Rector\CodeQuality\Rector\ClassMethod\ReturnTypeFromStrictScalarReturnExprRector;
use Rector\CodingStyle\Rector\ArrowFunction\StaticArrowFunctionRector;
use Rector\CodingStyle\Rector\ClassConst\VarConstantCommentRector;
use Rector\CodingStyle\Rector\ClassMethod\UnSpreadOperatorRector;
use Rector\CodingStyle\Rector\Stmt\NewlineAfterStatementRector;
use Rector\Config\RectorConfig;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Strict\Rector\AbstractFalsyScalarRuleFixerRector;
use Rector\Strict\Rector\BooleanNot\BooleanInBooleanNotRuleFixerRector;

return static function (RectorConfig $config): void {
    $config->paths([__DIR__ . '/src', __DIR__ . '/tests']);
    $config->phpVersion(PhpVersion::PHP_81);

    // Define what rule sets will be applied
    $config->import(LevelSetList::UP_TO_PHP_81);
    $config->import(SetList::CODE_QUALITY);
    $config->import(SetList::CODING_STYLE);
    $config->importNames();

    $config->ruleWithConfiguration(
        BooleanInBooleanNotRuleFixerRector::class,
        [
            AbstractFalsyScalarRuleFixerRector::TREAT_AS_NON_EMPTY => false,
        ]
    );

    // SKIP laravel
    $laravelClasses = [
        __DIR__ . '/src/Testing/Laravel/TestingApplication.php',
        __DIR__ . '/src/Testing/Laravel/TestingContainer.php',
        __DIR__ . '/src/Testing/Laravel/Filesystem/Filesystem.php',
    ];
    $config->skip([
        UnSpreadOperatorRector::class => $laravelClasses,
        ReturnTypeFromStrictScalarReturnExprRector::class => $laravelClasses,
        VarConstantCommentRector::class,
        NewlineAfterStatementRector::class,
        StaticArrowFunctionRector::class => [__DIR__ . '/src/Log/Managers/ConsoleOutputManager.php'],
        // We want to leave the relative constant path usage
        __DIR__ . '/tests/Feature/Testing/Commands/MakeExpectationCommand/*.php',
    ]);
};
