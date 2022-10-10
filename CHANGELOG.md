# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [v0.0.12] - 2022-10-10
### :sparkles: New Features
- [`77e40a6`](https://github.com/wrk-flow/larastrict/commit/77e40a63331969429309e2df9083c98a50e8a068) - **database**: Mimic save (timestamps, exists, generated id) for safe unique save action *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.11] - 2022-10-04
### :sparkles: New Features
- [`a381428`](https://github.com/wrk-flow/larastrict/commit/a3814286d11cce0091bc0ac0feb181f170e6b110) - **providers**: Service provider refactoring to provider flexible pipe register/boot and separation *(commit by [@pionl](https://github.com/pionl))*
- [`7d3cb75`](https://github.com/wrk-flow/larastrict/commit/7d3cb75a43b49ffd91943f76de15b457228d5f4a) - **providers**: Add ability to register views/translations/components for the provider *(commit by [@pionl](https://github.com/pionl))*

### :boom: BREAKING CHANGES
- due to [`a381428`](https://github.com/wrk-flow/larastrict/commit/a3814286d11cce0091bc0ac0feb181f170e6b110) - Service provider refactoring to provider flexible pipe register/boot and separation *(commit by [@pionl](https://github.com/pionl))*:

  Service provider refactoring to provider flexible pipe register/boot and separation


## [v0.0.10] - 2022-10-04
### :sparkles: New Features
- [`0a6deb6`](https://github.com/wrk-flow/larastrict/commit/0a6deb626ec0a55f390f2886c65fabb85bd2981e) - **testing**: Make service provider parameter in AssertProviderBinding/Routes null by default *(commit by [@pionl](https://github.com/pionl))*
- [`50c7eb2`](https://github.com/wrk-flow/larastrict/commit/50c7eb29ed7e5ef12aea3ec486fb170de43d5716) - **translations**: Allow changing default value for not found translation *(commit by [@pionl](https://github.com/pionl))*

### :boom: BREAKING CHANGES
- due to [`0a6deb6`](https://github.com/wrk-flow/larastrict/commit/0a6deb626ec0a55f390f2886c65fabb85bd2981e) - Make service provider parameter in AssertProviderBinding/Routes null by default *(commit by [@pionl](https://github.com/pionl))*:

  $registerServiceProvider is now third parameter instead of second.


## [v0.0.9] - 2022-09-29
### :sparkles: New Features
- [`964a854`](https://github.com/wrk-flow/larastrict/commit/964a8548934cffa748b90d20eede80b095e2af61) - **testing**: Allow larastrict maintainers use our artisan commands *(commit by [@pionl](https://github.com/pionl))*
- [`a776d5f`](https://github.com/wrk-flow/larastrict/commit/a776d5f383f37abeafaf683db5e0028166d73f0c) - **testing**: Add ability to test RunInTransaction/SafeUniqueSave actions using assert/expectation classes *(commit by [@pionl](https://github.com/pionl))*

### :boom: BREAKING CHANGES
- due to [`964a854`](https://github.com/wrk-flow/larastrict/commit/964a8548934cffa748b90d20eede80b095e2af61) - Allow larastrict maintainers use our artisan commands *(commit by [@pionl](https://github.com/pionl))*:

  (low) LaraStrictTestServiceProvider renmaned to TestServiceProvider


## [v0.0.8] - 2022-09-28
### :sparkles: New Features
- [`9733d67`](https://github.com/wrk-flow/larastrict/commit/9733d6769ea16f66c0f0531c16defcdfe2638c47) - **testing**: Add AssertProviderBindings for testing service provider bindings *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.7] - 2022-09-28
### :sparkles: New Features
- [`8f6ad8a`](https://github.com/wrk-flow/larastrict/commit/8f6ad8a0c05a48524d04faa296583c24d5590eba) - **testing**: Allow dynamically changing expectation call map *(commit by [@pionl](https://github.com/pionl))*

### :bug: Bug Fixes
- [`bcf775d`](https://github.com/wrk-flow/larastrict/commit/bcf775d2c847561260495f3f3717f153d0f2aaa5) - **testing**: Fix container->make with a closure *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.6] - 2022-09-27
### :sparkles: New Features
- [`d9a6287`](https://github.com/wrk-flow/larastrict/commit/d9a6287b69df4c757d4c64cb100caaece7ec42d6) - **provider**: Add ability to register Gate policies using contract *(commit by [@pionl](https://github.com/pionl))*
- [`2765d84`](https://github.com/wrk-flow/larastrict/commit/2765d847c0f6bc6dc0b807439da0fb32f37fcc01) - **testing**: Add TestingContainer and TestingApplicationRoutes *(commit by [@pionl](https://github.com/pionl))*

### :bug: Bug Fixes
- [`6f5a57e`](https://github.com/wrk-flow/larastrict/commit/6f5a57ed61171d5fafe4904265d332b7a7766f82) - **provider**: Call next in LoadProviderRoutesPipe *(commit by [@pionl](https://github.com/pionl))*
- [`82fa307`](https://github.com/wrk-flow/larastrict/commit/82fa30760dc58334e9872f04554b288c30aca0ff) - **provider**: Call next in SetFactoryResolvingProviderPipe *(commit by [@pionl](https://github.com/pionl))*

### :white_check_mark: Tests
- [`e30efbf`](https://github.com/wrk-flow/larastrict/commit/e30efbfd37da1b8444e268f442b6f401b0bb9926) - **provider**: Improve code coverage for LoadProviderRoutesPipe *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.5] - 2022-09-27
### :sparkles: New Features
- [`763b570`](https://github.com/wrk-flow/larastrict/commit/763b570e6df7b88dc151d30dc6a86aaec4a94da2) - **testing**: Improve ability to assert registered routes with only allowed routes *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.4] - 2022-09-27
### :sparkles: New Features
- [`ab61bcb`](https://github.com/wrk-flow/larastrict/commit/ab61bcb867a9eac653b64b030e168640f545f333) - **provider**: Add ability to provide custom route action with reusable file suffix *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.3] - 2022-09-27
### :wrench: Chores
- [`03618de`](https://github.com/wrk-flow/larastrict/commit/03618de406e7552f6eb56e9df28c318454f5fbc8) - **provider**: CreateCustomRouteActionContract renamed to RegisterCustomRouteActionContract *(commit by [@pionl](https://github.com/pionl))*

### :boom: BREAKING CHANGES
- due to [`03618de`](https://github.com/wrk-flow/larastrict/commit/03618de406e7552f6eb56e9df28c318454f5fbc8) - CreateCustomRouteActionContract renamed to RegisterCustomRouteActionContract *(commit by [@pionl](https://github.com/pionl))*:

  CreateCustomRouteActionContract renamed to RegisterCustomRouteActionContract


## [v0.0.2] - 2022-09-27
### :sparkles: New Features
- [`428e83c`](https://github.com/wrk-flow/larastrict/commit/428e83cf24bd94a5e952acd7736fbd264f73f9b7) - Add ablity to register custom route with action class for reusability *(commit by [@pionl](https://github.com/pionl))*


[v0.0.2]: https://github.com/wrk-flow/larastrict/compare/v0.0.1...v0.0.2
[v0.0.3]: https://github.com/wrk-flow/larastrict/compare/v0.0.2...v0.0.3
[v0.0.4]: https://github.com/wrk-flow/larastrict/compare/v0.0.3...v0.0.4
[v0.0.5]: https://github.com/wrk-flow/larastrict/compare/v0.0.4...v0.0.5
[v0.0.6]: https://github.com/wrk-flow/larastrict/compare/v0.0.5...v0.0.6
[v0.0.7]: https://github.com/wrk-flow/larastrict/compare/v0.0.6...v0.0.7
[v0.0.8]: https://github.com/wrk-flow/larastrict/compare/v0.0.7...v0.0.8
[v0.0.9]: https://github.com/wrk-flow/larastrict/compare/v0.0.8...v0.0.9
[v0.0.10]: https://github.com/wrk-flow/larastrict/compare/v0.0.9...v0.0.10
[v0.0.11]: https://github.com/wrk-flow/larastrict/compare/v0.0.10...v0.0.11
[v0.0.12]: https://github.com/wrk-flow/larastrict/compare/v0.0.11...v0.0.12