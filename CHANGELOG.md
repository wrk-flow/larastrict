# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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