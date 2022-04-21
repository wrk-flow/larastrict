<?php

declare(strict_types=1);

namespace LaraStrict\Core\Services;

class ImplementsService
{
    // Cache only on injection at this moment. We could make it as singleton and use CacheMe (memory or even cache)
    private array $classImplementsCache = [];

    /**
     * Returns a map of interfaces that object implements. Returns empty array if object does not exists or there is
     * different erorr.
     *
     * @return array<string, string>
     */
    public function get(object $object): array
    {
        $className = $object::class;

        if (array_key_exists($className, $this->classImplementsCache) === false) {
            $classImplements = class_implements($object);
            $this->classImplementsCache[$className] = is_array($classImplements) ? $classImplements : [];
        }

        return $this->classImplementsCache[$className];
    }

    /**
     * Checks if given interface is used within the object
     */
    public function check(object $object, string $interface): bool
    {
        $result = $this->get($object);

        return array_key_exists($interface, $result);
    }
}
