# LaraStrict contribution

Feel free to contribute. Guide lines contributions:

## Bug fixes

For bug fixes create and issue and pull request if possible.

## Ideas

Use the discussion functionality and propose your idea:

- What you want to solve?
- Sample proof of concept code? (just how it could look)

## Commit messages

- We are using [conventionalcommits](https://www.conventionalcommits.org/en/v1.0.0/)
- CHANGELOG.md is generated from given commits using this [action](https://github.com/requarks/changelog-action).
- Use: `fix: feat:, build:, chore:, ci:, docs:, style:, refactor:, perf:, test:`
- These keywords will ignore changelog change `build,docs,style`

## Wait to take in account

- Always design your classes with dependency injection in mind (possibly constructor).
- Always think about tests -> how they should be written and if it is easy.

## Lint and tests

```bash
composer run check
```

We are using set of tools to ensure that the code is consistent. Run this before pushing your code changes.

### [PHPStan](https://phpstan.org)

```bash
composer run check
```

### [Rector](https://github.com/rectorphp/rector)

```bash
composer run check
```

### [Easy coding standard](https://github.com/symplify/easy-coding-standard)

```bash
composer run check
```

## Clone Larastrict repository in our project and use it

1. `git submodule add git@github.com:wrk-flow/larastrict.git core`
2. Add this to your `composer.json` and `repositories` key.
```php
{
  "type": "path",
  "url": "./core"
}
```
2. `composer require wrkflow/larastrict:*`
4. (optional, IDEA) Mark `core/src` directory as `Sources root` and set `Larastrict` as the namespace.

## Stubfiles

For MakeExpectationCommand we are using stubs. If you want to generate the stub files from current command output then run:

- Composer: `composer test:stubs`
- PHPStorm run configuration: `test:stubs`

## Fixes

- `nikic/php-parser` - on `v4.13.0` enum with value named Array fails to be parsed, `v4.14.0` works
