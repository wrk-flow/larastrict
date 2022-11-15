<?php

declare(strict_types=1);

namespace LaraStrict\Testing\Actions;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Contracts\Container\Container;
use LaraStrict\Testing\Entities\PhpDocEntity;
use LaraStrict\Testing\Enums\PhpType;
use PHPStan\PhpDoc\PhpDocStringResolver;
use ReflectionMethod;

class ParsePhpDocAction
{
    private ?PhpDocStringResolver $phpDocStringResolver = null;

    public function __construct(Container $container)
    {
        if (class_exists(PhpDocStringResolver::class)) {
            try {
                $this->phpDocStringResolver = $container->make(PhpDocStringResolver::class);
            } catch (BindingResolutionException) {
                // Package phpstan/phpdoc-parser not installed
            }
        }
    }

    public function execute(ReflectionMethod $method): PhpDocEntity
    {
        if ($this->phpDocStringResolver === null) {
            return new PhpDocEntity();
        }

        $comment = $method->getDocComment();

        if ($comment === false) {
            return new PhpDocEntity();
        }

        $doc = $this->phpDocStringResolver->resolve($comment);

        $returnTags = $doc->getReturnTagValues();
        $returnType = PhpType::Unknown;

        if ($returnTags !== []) {
            $name = (string) $returnTags[0]->type;
            $returnType = match ($name) {
                '$this', 'self', 'static' => PhpType::Self,
                'void' => PhpType::Void,
                default => PhpType::Mixed,
            };
        }

        return new PhpDocEntity(returnType: $returnType);
    }
}
