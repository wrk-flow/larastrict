## Migrations

- When migration is executed on production it is recommended to purge the migration (so refactoring will not break the migrations).
- Use constants for attributes / length in your model.
- Use `AbstractMigration` to create / alter / drop tables using model (to use the correct table name)
- As the Laravel does not support transaction you should adjust only one table per migration. To "force" this you are advised to use classes below.

### AbstractCreateMigration

> Migration with create and drop statements in up/down

- Implement `public function schema(Blueprint $table): void;` and `public function getModelClass(): string;`
