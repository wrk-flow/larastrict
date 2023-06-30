<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\ClassNotation\ClassAttributesSeparationFixer;
use PhpCsFixer\Fixer\ControlStructure\YodaStyleFixer;
use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Set\SetList;

return static function (ECSConfig $containerConfigurator): void {
    $containerConfigurator->import(SetList::PSR_12);
    $containerConfigurator->import(SetList::SYMPLIFY);
    $containerConfigurator->import(SetList::COMMON);
    $containerConfigurator->import(SetList::CLEAN_CODE);

    $containerConfigurator->ruleWithConfiguration(ClassAttributesSeparationFixer::class, [
        'elements' => [
            'const' => 'only_if_meta',
            'property' => 'one',
            'method' => 'one',
        ],
    ]);

    $containerConfigurator->parallel();
    $containerConfigurator->paths(
        [__DIR__ . '/src', __DIR__ . '/tests', __DIR__ . '/ecs.php', __DIR__ . '/rector.php']
    );
    $containerConfigurator->skip([
        YodaStyleFixer::class,
        // We want to leave the relative constant path usage
        __DIR__ . '/tests/Feature/Testing/Commands/MakeExpectationCommand/*.php',
    ]);
};
