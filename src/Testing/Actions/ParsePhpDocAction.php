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
        // This optional integration necessarily depends on PHPStan's non-public parser API.
        // @phpstan-ignore phpstanApi.classConstant
        if (class_exists(PhpDocStringResolver::class)) {
            try {
                // @phpstan-ignore phpstanApi.classConstant
                $this->phpDocStringResolver = $container->make(PhpDocStringResolver::class);
            } catch (BindingResolutionException) {
                // Package phpstan/phpdoc-parser not installed
            }
        }
    }

    public function execute(ReflectionMethod $method): PhpDocEntity
    {
        // @phpstan-ignore phpstanApi.class
        if (! $this->phpDocStringResolver instanceof PhpDocStringResolver) {
            return new PhpDocEntity();
        }

        $comment = $method->getDocComment();

        if ($comment === false) {
            return new PhpDocEntity();
        }

        // This optional integration necessarily depends on PHPStan's non-public parser API.
        // @phpstan-ignore phpstanApi.method
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
