<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Core\Configuration\Option;
use Rector\Core\ValueObject\PhpVersion;
use Rector\Set\ValueObject\LevelSetList;
use Rector\Set\ValueObject\SetList;
use Rector\Strict\Rector\AbstractFalsyScalarRuleFixerRector;
use Rector\Strict\Rector\BooleanNot\BooleanInBooleanNotRuleFixerRector;
use Rector\Strict\Rector\Ternary\BooleanInTernaryOperatorRuleFixerRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return static function (RectorConfig $config): void {

    $config->paths([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ]);
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
};
