# Database

## Conventions

- For reusable query parts always define `Scopes` that will extend

## Models

- Use constants


## Migrations

- When migration is executed on production it is recommended to purge the migration (so refactoring will not break the migrations).
- Use constants for attributes / length in your model.
- Use `AbstractMigration` to create / alter / drop tables using model (to use the correct table name)
- As the Laravel does not support transaction you should adjust only one table per migration. To "force" this you are advised to use classes below.

### AbstractCreateMigration

> Migration with create and drop statements in up/down

- Implement `public function schema(Blueprint $table): void;` and `public function getModelClass(): string;`

## Queries

> Provide a way how define reusable queries that will separate your service (that is testable by unit test) and DB queries (that can be separately tested with DB connection)

- Always implement `execute` method and setup exact object that will be returned.
- Do not provide to many "arguments". Limit it to max 3. If you need more flexibility, make more queries with "scopes".
- You can extend `AbstractEloquentQuery` that contains basic methods for find / get / etc.
- Use `construct` for dependency injection.
- Use dependency injection to inject the query in your service / action.

### Chunked query

Call `$this->chunk` in your execute your query using scopes

```php
class GetObjectChunksForPriceListCheckQuery extends AbstractObjectQuery
{
    public function execute(array $ids = []): ChunkedModelQueryResult
    {
        return $this->chunk([
            new WithToursRelationScope(),
            0 == count($ids) ? null : new WhereIdsScope($ids, $this->getIdColumn()),
        ]);
    }
}
```

If you want to customize the query using `Eloquent` query then customize the query using `query` property.

```
class GetConfirmationsForExpirationQuery extends AbstractConfirmationQuery
{
    public function execute(): ChunkedModelQueryResult
    {
        $query = $this->chunk();

        $query->query
            ->whereDate(Confirmation::ATTRIBUTE_EXPIRATION_AT, '<', now());

        return $query;
    }
}
```

Then use dependency injection to give you the query and use `execute`.

```php

class CheckPriceListsCommand extends Command
{
    public function handle(
        GetObjectChunksForPriceListCheckQuery $getObjectChunks
    ): void {
        $objectId = convert_to_int($this->argument('object_id'));
        $notify = convert_to_bool($this->option('notify'));

        $found = $getObjectChunks->execute(is_numeric($objectId) ? [$objectId] : [])
            ->onEntryById(function (AnObject $object) use ($notify) {
                // Do something
            });

        if (0 === $found) {
            $this->error('No objects found');
        }
    }
}
```
