---
title: Introduction
position: 1
---

<img src="https://img.shields.io/badge/PHPStan-8-blue" class="inline-flex" style="margin: 0;" /> 
<img src="https://img.shields.io/badge/PHP-8.1-B0B3D6"  class="inline-flex" style="margin: 0;" />
<img src="https://img.shields.io/badge/Laravel-9-fb503b"  class="inline-flex" style="margin: 0;" />
<img src="https://img.shields.io/endpoint?url=https://gist.githubusercontent.com/pionl/8eeaf1185a65b196e8bbb06c1b103154/raw/coverage.json"  class="inline-flex" style="margin: 0;" />


# DOCUMENTATION in progress 

## Conventions

### Actions

Actions are designed for simple one way business logic "action" with `execute` function that must be implemented.

### Services

Contains business logic that is more "central" (has multiple methods). Something like `ManagePersonService` with `create/update/etc` methods.

Still its more attractive to creates actions for each method I've mentioned above.

### Database [docs](./src/Database/README.md)

#### Queries

The main problem with queries that they are hard to unit test. You can use `Mockery` but there are a limits. You can use
repositories, but then you tend to make them universal (with scopes) and yet again, they are hard to test.

With queries, you should always make simple class with `execute` method that do the thing we need without heavy property
customization. Always prefer to create new query that can be tested separately.

### Console [docs](./src/Console/README.md)

Improved way how to register commands / schedules / views in more modular way (to follow DDD).

### Managers

Managers are mainly singleton and holds data that needs to be accessed from multiple services / actions / etc.
