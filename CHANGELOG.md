# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [v0.0.23] - 2022-11-22
### :sparkles: New Features
- [`8b2e816`](https://github.com/wrk-flow/larastrict/commit/8b2e816901c176b9974f822cddcf1af9a103b870) - **Testing**: Add assert Illuminate\Contracts\Events\Dispatcher *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.22] - 2022-11-22
### :sparkles: New Features
- [`e4068ca`](https://github.com/wrk-flow/larastrict/commit/e4068cac67df0d43e45b40e12432b2e8d49f200d) - **Testing**: Support passing files/cookies in CreateRequest concern *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.21] - 2022-11-22
### :sparkles: New Features
- [`ff0ea2c`](https://github.com/wrk-flow/larastrict/commit/ff0ea2c21e9fe06e1b9368d2edd33bd5439029ed) - **Testing**: Add concern for testing Assert classes *(commit by [@pionl](https://github.com/pionl))*
- [`5bcfe2b`](https://github.com/wrk-flow/larastrict/commit/5bcfe2b5226008c5f200033a155d5e247ee93840) - **Testing**: Add assert for Illuminate\Contracts\Debug\ExceptionHandler *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.20] - 2022-11-22
### :sparkles: New Features
- [`443d42e`](https://github.com/wrk-flow/larastrict/commit/443d42e93a0c6ca4d8e1263113c91d8ae7af95fa) - **Testing**: Support using $this->app in TestData concern *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.19] - 2022-11-21
### :sparkles: New Features
- [`66f9583`](https://github.com/wrk-flow/larastrict/commit/66f9583088316e34dc791706247ecd0c015b729d) - **Testing**: Add TestData concern for simple test using dataProvider and type safe assert *(commit by [@pionl](https://github.com/pionl))*
- [`47b1342`](https://github.com/wrk-flow/larastrict/commit/47b13422d8e7d29ec1f935fc2cdd5836cedbaf16) - **Testing**: Add AssertProviderSingletons for testing singletons *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.18] - 2022-11-16
### :sparkles: New Features
- [`a9d1a29`](https://github.com/wrk-flow/larastrict/commit/a9d1a295fab370f26ea9a3c791c098838ea7cd84) - **Testing**: Ensure that CreateRequest return request with correct url and json accept header *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.17] - 2022-11-16
### :sparkles: New Features
- [`47fdcf2`](https://github.com/wrk-flow/larastrict/commit/47fdcf2882a0bfc4c0687ed5949d00affd512dfd) - **Http**: Make $id public in CreatedResource *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.16] - 2022-11-15
### :sparkles: New Features
- [`1d95b3e`](https://github.com/wrk-flow/larastrict/commit/1d95b3e0d71c8ae955cea114af8f186ce89dbcc0) - **Testing**: Add ability to generate test Assert for all contracts methods *(commit by [@pionl](https://github.com/pionl))*
- [`1d95b3e`](https://github.com/wrk-flow/larastrict/commit/1d95b3e0d71c8ae955cea114af8f186ce89dbcc0) - **Testing**: Add ability to test `Illuminate\Contracts\Auth\Access\Gate` using `GateAssert`.

### :bug: Bug Fixes
- [`36197b4`](https://github.com/wrk-flow/larastrict/commit/36197b4f0163bc26d6daa563836f3efe87681e50) - **Testing**: Fix artisan usage with larastrict commands *(commit by [@pionl](https://github.com/pionl))*
- [`0cd12fe`](https://github.com/wrk-flow/larastrict/commit/0cd12fe9abbb3cc3ebeb6f82aea51b0f47467cdb) - **Testing**: Update dependencies and fix phpstan warnning on latest testbench version *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.15] - 2022-10-13
### :sparkles: New Features
- [`28b335a`](https://github.com/wrk-flow/larastrict/commit/28b335a8caceec6a579891046b68eb3b491ba0dd) - **Database**: Delete/forceDelete will always return int (0 for no deletion was made) *(commit by [@pionl](https://github.com/pionl))*
- [`066cdca`](https://github.com/wrk-flow/larastrict/commit/066cdca96323158542f99d5f1117f55339a968a3) - **Testing**: Add ability to create custom requests in tests *(commit by [@pionl](https://github.com/pionl))*

### :boom: BREAKING CHANGES
- due to [`28b335a`](https://github.com/wrk-flow/larastrict/commit/28b335a8caceec6a579891046b68eb3b491ba0dd) - Delete/forceDelete will always return int (0 for no deletion was made) *(commit by [@pionl](https://github.com/pionl))*:

  Delete/forceDelete will always return int (0 for no deletion was made)


## [v0.0.14] - 2022-10-11
### :sparkles: New Features
- [`9e178a0`](https://github.com/wrk-flow/larastrict/commit/9e178a0a854115e85f025619acbf0909080ccaa7) - **database**: Set wasRecentlyCreated to true if setId is set for safe unique save action *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.13] - 2022-10-11
### :sparkles: New Features
- [`9f1eb6e`](https://github.com/wrk-flow/larastrict/commit/9f1eb6ef79f9ae07fa64f8d773636e84c652c4f5) - **validation**: Handle float with comma in NumberRule and improve overflow detection *(commit by [@pionl](https://github.com/pionl))*


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
[v0.0.13]: https://github.com/wrk-flow/larastrict/compare/v0.0.12...v0.0.13
[v0.0.14]: https://github.com/wrk-flow/larastrict/compare/v0.0.13...v0.0.14
[v0.0.15]: https://github.com/wrk-flow/larastrict/compare/v0.0.14...v0.0.15
[v0.0.16]: https://github.com/wrk-flow/larastrict/compare/v0.0.15...v0.0.16

[v0.0.17]: https://github.com/wrk-flow/larastrict/compare/v0.0.16...v0.0.17
[v0.0.18]: https://github.com/wrk-flow/larastrict/compare/v0.0.17...v0.0.18
[v0.0.19]: https://github.com/wrk-flow/larastrict/compare/v0.0.18...v0.0.19
[v0.0.20]: https://github.com/wrk-flow/larastrict/compare/v0.0.19...v0.0.20
[v0.0.21]: https://github.com/wrk-flow/larastrict/compare/v0.0.20...v0.0.21
[v0.0.22]: https://github.com/wrk-flow/larastrict/compare/v0.0.21...v0.0.22
[v0.0.23]: https://github.com/wrk-flow/larastrict/compare/v0.0.22...v0.0.23