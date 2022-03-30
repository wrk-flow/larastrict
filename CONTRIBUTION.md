# Larastrict contribution


## Clone Larastrict repository in our project and use it

1. `git clone git@github.com:wrk-flow/larastrict.git core`
2. Add this to your `composer.json` and `repositories` key.
```php
{
  "type": "path",
  "url": "./core"
}
```
2. `composer require wrkflow/larascrict`
4. (optional, IDEA) Mark `core/src` directory as `Sources root` and set `Larastrict` as the namespace.
