---
title: Queries
category: Database
---

> Place all queries in your domain in `Queries` namespace and always use `Query` suffix.

- 🛠 Wrapping your eloquent/database queries in class allows full easy re-usability and testability.
- ✓ Test your queries using feature test that will use database connection (ensure it works).
- ☠️ Don't make the query universal, focus on the "business" use case that the query should do.
- ⮑ Always implement `execute` method and setup exact object that will be returned.
- 🙌 Do not provide to many "arguments". Limit it to max 3. If you need more flexibility, make more queries with "scopes".
- 🚀 Extend `AbstractEloquentQuery` that contains basic methods for find / get / etc.
- 🛠 Use `construct` for dependency injections.

## Chunked queries (select)

> By default, chunks are ordered by `key`. This can be changed by `$orderBy` parameter.

- Name your query `GetChunked{XX}Query`.

**Create a query that with execute method, call `chunk` method that will return `ChunkedModelQueryResult`**

> In some rare cases you need to change the order. You can pass `$orderBy` parameter with `OrderScope` scopes.

```php
<?php

declare(strict_types=1);

namespace App\ObjectType\Queries;

use App\Object\Models\Scopes\WithObjectScope;
use App\ObjectProvider\Model\Scopes\WhereProviderIds;
use LaraStrict\Database\Queries\ChunkedModelQueryResult;

class GetChunkedProviderObjectTypesQuery extends AbstractObjectTypeQuery
{
    /**
     * @return ChunkedModelQueryResult<ObjectType>
     */
    public function execute(int $providerId): ChunkedModelQueryResult
    {
        return $this->chunk([
            new WithObjectScope(
                relationScopes: [
                    new WhereProviderIds([$providerId]),
                ],
                useHas: true
            ),
        ]);
    }
}
```

> This query loads a chunk of object types of given provider (connected via object relation).

Then you can start looping chunks or entries.

### Get collection of models for each chunk

>  This is same as calling Laravel chunk method.

First argument is a `Closure` that will receive the `Collection`. Second parameter is a chunk size (default 100).

```php
class SomeAction
{
    public function __construct(
        private readonly GetChunkedProviderObjectTypesQuery $chunkedProviderObjectTypesQuery
    ) {
    }

    public function execute(int $providerId): void
    {
        $this->chunkedProviderObjectTypesQuery->execute($providerId)
            ->onChunk(function (\Illuminate\Database\Eloquent\Collection $collection)  {
            
            })
    }
}
```

### Get model for each chunk

⮑ First argument is a `Closure` that will receive the `Model`. Second parameter is a chunk size (default 100).

⮐ Returns number of items processed.

```php
class SomeAction
{
    public function __construct(
        private readonly GetChunkedProviderObjectTypesQuery $chunkedProviderObjectTypesQuery
    ) {
    }

    public function execute(int $providerId): void
    {
        $found = $this->chunkedProviderObjectTypesQuery->execute($providerId)
            ->onEntry(function (\App\Models\ObjectType $objectType)  {
            
            })
          
        if (0 === $found) {
            // Nothing found
        }
    }
}
```

#### Auto-converting Model to any type

You can also automatically convert Model to any value you want using `setTransformOnEntry`. Call this function before
`onEntry`.

```php
$this->chunkedProviderObjectTypesQuery->execute($event->providerId)
    ->setTransformOnEntry(fn (ObjectType $type) => $this->transformer->transform($type))
    ->onEntry(function (Entity $entity) {
        
    })
```

> Do not forget to correctly type your model and result entity.

### Get ids for each chunk

First argument is a `Closure` that will receive array of `string|int`. Second parameter is a chunk size (default 100).

```php
$this->chunkedProviderObjectTypesQuery->execute($event->providerId)
    ->onKeys(function (array $ids) {
        $this->setSomethingNullForObjectTypesQuery->execute($ids);
    });
```

> Ideal for making and update (query) in "batch" mode.

## Chunked writing (insert)


## Find or fail

> Name your query `Get{XX}Query`.

Finds given model by given $key. You can pass `scopes` and you can create a custom exception (by default ModelNotFoundException is thrown).

```php
<?php

declare(strict_types=1);

namespace App\ObjectProvider\Queries;

use App\Models\ObjectProvider;
use App\ObjectProvider\Exceptions\ObjectProviderNotFoundException;
use LaraStrict\Database\Scopes\SelectScope;

class GetProviderForChannelManagerUpdateQuery extends AbstractObjectProviderQuery
{
    public function execute(int $providerId): ObjectProvider
    {
        return $this->findOrFail(
            key: $providerId,
            scopes: [
                new SelectScope([$this->getKeyColumn(), 'name', ObjectProvider::ATTRIBUTE_CHANNEL_MANAGER_ID]),
            ],
            customException: fn (int $id) => new ObjectProviderNotFoundException($id),
        );
    }
}
```

## Get key column for query model

> Query knows which model the query is using. This enables you to use this dynamic access of a key attribute name.

```php
public function execute(int $providerId): ObjectProvider
{
    return $this->findOrFail(
        key: $providerId,
        scopes: [
            new SelectScope([$this->getKeyColumn()])
        ],
    );
}
```
