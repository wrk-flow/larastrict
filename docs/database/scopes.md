# Scopes

> Place all scopes in your domain in `Models\Scopes` namespace and always use `Scope` suffix.

✓ Extend `AbstractScope` instead of `Scope` interface

## Relation scope

> Name your scope `With{RelationName}Scope` and extend AbstractNestedRelationScope. Place the scope where the "relation"
> model lives.

`AbstractNestedRelationScope` helps you to make reusable relation scopes with ability to apply scopes on the
relation. _Allows you to load a relation and select specified columns, load more relations and others using scope
chaining_.

The scope works in 2 modes:

- _(default)_ loads the relation (uses `with`)
- _(pass `useHas: true` constructor parameter)_ filters by the relation (uses `whereHas`)

Create a scope that can be used with a model that has `type` relation in the model.

```php
<?php

declare(strict_types=1);

namespace App\Object\Models\Scopes;

use LaraStrict\Database\Scopes\AbstractNestedRelationScope;

class WithObjectScope extends AbstractNestedRelationScope
{
    protected function getRelationName(): string
    {
        return 'object';
    }
}
```

Use the scope in your `Query`

```php
new WithObjectScope(relationScopes: [
    new SelectScope(['id', 'object_name']),
])
```

> This example load `object` relation and selects given attributes.

```php
new WithObjectScope(
    relationScopes: [
        new WhereProviderIds([$providerId]),
    ],
    useHas: true
),
```

> This example filters entries by given object relation that has given provider_id attribute set to given value- 

