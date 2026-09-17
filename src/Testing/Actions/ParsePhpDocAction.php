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
        $comment = $method->getDocComment();

        if ($comment === false) {
            return new PhpDocEntity();
        }

        $name = $this->getReturnTypeName($comment);

        if ($name === null) {
            return new PhpDocEntity();
        }

        $returnType = match ($name) {
            '$this', 'self', 'static' => PhpType::Self,
            'void' => PhpType::Void,
            default => PhpType::Mixed,
        };

        return new PhpDocEntity(returnType: $returnType, returnTypeName: $name);
    }

    private function getReturnTypeName(string $comment): ?string
    {
        // @phpstan-ignore phpstanApi.class
        if ($this->phpDocStringResolver instanceof PhpDocStringResolver) {
            // This optional integration necessarily depends on PHPStan's non-public parser API.
            // @phpstan-ignore phpstanApi.method
            $returnTags = $this->phpDocStringResolver->resolve($comment)
                ->getReturnTagValues();

            if ($returnTags !== []) {
                return (string) $returnTags[0]->type;
            }
        }

        preg_match('/@return\s+(\S+)/', $comment, $matches);

        return $matches[1] ?? null;
    }
}
