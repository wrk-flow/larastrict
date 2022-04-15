# LaraStrict contribution

Feel free to contribute. Guide lines contributions:

## Bug fixes

For bug fixes create and issue and pull request if possible.

## Ideas

Use the discussion functionality and propose your idea:

- What you want to solve?
- Sample proof of concept code? (just how it could look)

## Wait to take in account

- Always design your classes with dependency injection in mind (possibly constructor).
- Always think about tests -> how they should be written and if it is easy.

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
