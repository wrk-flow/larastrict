# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [v0.0.86] - 2024-08-07
### :boom: BREAKING CHANGES
- due to [`a1a54e3`](https://github.com/wrk-flow/larastrict/commit/a1a54e33e569c487b4a5d425aef38ceba8fc5beb) - Provide @template for JsonResource $resource for better type safe *(commit by [@pionl](https://github.com/pionl))*:

  PHPStan will now throw an error if you pass incorrect value to __construct or Resource::collection  
  - made setContainer/getContainer/resourceArray/instance final


### :sparkles: New Features
- [`a1a54e3`](https://github.com/wrk-flow/larastrict/commit/a1a54e33e569c487b4a5d425aef38ceba8fc5beb) - **PHPStan**: Provide @template for JsonResource $resource for better type safe *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.85] - 2024-08-06
### :bug: Bug Fixes
- [`faa4bae`](https://github.com/wrk-flow/larastrict/commit/faa4baef78d757c8f9b7e7228effd8c9b57bc879) - **ChunkWriteStateEntity**: phpdoc *(commit by [@h4kuna](https://github.com/h4kuna))*
- [`9816cf3`](https://github.com/wrk-flow/larastrict/commit/9816cf31a11d1e691c10721b3e9359c61904e951) - **CommandInQueue**: update caseId *(commit by [@h4kuna](https://github.com/h4kuna))*
- [`096ffce`](https://github.com/wrk-flow/larastrict/commit/096ffcec09383d4eb5fcca62467f2022e7a90ba5) - **SqlTestEnable**: add Attribute from PhpUnit *(commit by [@h4kuna](https://github.com/h4kuna))*


## [v0.0.84] - 2024-07-30
### :sparkles: New Features
- [`7468a7c`](https://github.com/wrk-flow/larastrict/commit/7468a7c3a7207df2204ae36938e478053a251148) - **SqlTestEnable**: add fake connector for sql lite *(commit by [@h4kuna](https://github.com/h4kuna))*
- [`52fc7fa`](https://github.com/wrk-flow/larastrict/commit/52fc7fadb1fc44b14b29957d2bae9e07b8aa780d) - **Testing**: use native hooks instead of method overwrite *(commit by [@h4kuna](https://github.com/h4kuna))*
- [`c6384f8`](https://github.com/wrk-flow/larastrict/commit/c6384f82fb9f3a46108c7d64712c0431d6613758) - **Database**: add ChunkWriteService *(commit by [@h4kuna](https://github.com/h4kuna))*
- [`7709c76`](https://github.com/wrk-flow/larastrict/commit/7709c76b1fe700acfa4d548e8131e3788906cf24) - **serialize**: add dependency on h4kuna/serialize *(commit by [@h4kuna](https://github.com/h4kuna))*


## [v0.0.83] - 2024-07-29
### :boom: BREAKING CHANGES
- due to [`d9e2469`](https://github.com/wrk-flow/larastrict/commit/d9e24693289f8731e28e63c55c884a638874db10) - Fix deleting cache in context and drop tags usage by default *(commit by [@pionl](https://github.com/pionl))*:

  Drop default tag for context cache - Laravel offical recommendation is not to use tags with redis


### :bug: Bug Fixes
- [`d9e2469`](https://github.com/wrk-flow/larastrict/commit/d9e24693289f8731e28e63c55c884a638874db10) - **Context**: Fix deleting cache in context and drop tags usage by default *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.82] - 2024-03-08
### :sparkles: New Features
- [`64d2322`](https://github.com/wrk-flow/larastrict/commit/64d232225b102a8f2cfdc5d427d4f38a5995cd6e) - **Database**: Improve phpstan support for scopes *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.81] - 2024-02-28
### :sparkles: New Features
- [`3429635`](https://github.com/wrk-flow/larastrict/commit/3429635985896bc7b56dceaa0c2c86ff8cdf95ce) - **Queue**: Add _preHook closure to RunJobActionContractExpectation *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.80] - 2024-02-28
### :bug: Bug Fixes
- [`e1d93a3`](https://github.com/wrk-flow/larastrict/commit/e1d93a3ce931133d7d8d29f76de3b843519e0ec2) - **Queue**: Improve RunJobActionContract $method signature (nullable) *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.79] - 2024-02-28
### :bug: Bug Fixes
- [`28cfde8`](https://github.com/wrk-flow/larastrict/commit/28cfde81c8f6ecfd65acce29fbe10adf5f0e5ef8) - **Queue**: Add missing $method parameter to RunJobActionContract *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.78] - 2024-02-28
### :sparkles: New Features
- [`046a9e3`](https://github.com/wrk-flow/larastrict/commit/046a9e32ef4cfeb5a1d05f73aab6153e300956cf) - **Queue**: Add ability to dispatch job in testable way *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.77] - 2024-02-06
### :sparkles: New Features
- [`e2eb679`](https://github.com/wrk-flow/larastrict/commit/e2eb67978ad676af2deddedfd3cb60e8333da41a) - **CacheMeService**: ttl defined like seconds instead of minutes *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.76] - 2023-12-11
### :sparkles: New Features
- [`9a1ddb6`](https://github.com/wrk-flow/larastrict/commit/9a1ddb68435d0b04f86c1c184e6e78f12a9318f6) - **ServiceProvider**: Add ability to get tagged classes of given implementation *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.75] - 2023-12-10
### :boom: BREAKING CHANGES
- due to [`7804785`](https://github.com/wrk-flow/larastrict/commit/7804785c13ad12e10b3e8da85ed47ae4341469ca) - Improve PHPStan support for ContextEventsService *(commit by [@pionl](https://github.com/pionl))*:

  Dropped Closure event due the bad type usage


### :sparkles: New Features
- [`7804785`](https://github.com/wrk-flow/larastrict/commit/7804785c13ad12e10b3e8da85ed47ae4341469ca) - **Context**: Improve PHPStan support for ContextEventsService *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.74] - 2023-11-22
### :boom: BREAKING CHANGES
- due to [`dcb79f3`](https://github.com/wrk-flow/larastrict/commit/dcb79f34653cfbb32a5d1dbd13c726704b665457) - OrderByValuesScope is now from ASC to DESC order of given values *(commit by [@pionl](https://github.com/pionl))*:

  Values must be ordered from prefered order to last wanted order (now it was incorrectly used)


### :bug: Bug Fixes
- [`dcb79f3`](https://github.com/wrk-flow/larastrict/commit/dcb79f34653cfbb32a5d1dbd13c726704b665457) - **Database**: OrderByValuesScope is now from ASC to DESC order of given values *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.73] - 2023-11-16
### :bug: Bug Fixes
- [`c644785`](https://github.com/wrk-flow/larastrict/commit/c6447853ab3aca2cdb74cae8c980ec2f94980f8d) - **Testing**: Internal variables for generated assert has prefix underscore *(commit by [@h4kuna](https://github.com/h4kuna))*


## [v0.0.72] - 2023-11-11
### :bug: Bug Fixes
- [`942323d`](https://github.com/wrk-flow/larastrict/commit/942323d97554c7430af50b4a742a7dbc323c13ff) - **Testing**: Fix assert listener when closure listener is registered *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.71] - 2023-10-12
### :sparkles: New Features
- [`e20cea1`](https://github.com/wrk-flow/larastrict/commit/e20cea1b6107d325b7ca703cd7d98b28959e5a0f) - **Core**: Add contract for sleep service with no sleep implementation in tests *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.70] - 2023-09-05
### :sparkles: New Features
- [`60da0a8`](https://github.com/wrk-flow/larastrict/commit/60da0a8623e63428a72c6fcb218dcb88403510af) - **Testing**: GateAssert->authorize now throws exception if false response is returned *(commit by [@pionl](https://github.com/pionl))*
- [`872fe0c`](https://github.com/wrk-flow/larastrict/commit/872fe0c8fe9b0e036332aef25cc98fb8a31d76f1) - **Testing**: CreateRequest now accept user parameter that is passed to request *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.69] - 2023-07-24
### :boom: BREAKING CHANGES
- due to [`ecbd60b`](https://github.com/wrk-flow/larastrict/commit/ecbd60b80eda06fc18a5ac4dd866ae8d6f8490ad) - Add ability to create request without Laravel container *(commit by [@pionl](https://github.com/pionl))*:

  createPostRequest has been renamed to createAndValidateRequest


### :sparkles: New Features
- [`ab64cfa`](https://github.com/wrk-flow/larastrict/commit/ab64cfae0f90e2876236c31519ea8bf17c83bb66) - **Testing**: Move MockModels to Testing/Concerns namespace *(commit by [@pionl](https://github.com/pionl))*
- [`ecbd60b`](https://github.com/wrk-flow/larastrict/commit/ecbd60b80eda06fc18a5ac4dd866ae8d6f8490ad) - **Testing**: Add ability to create request without Laravel container *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.68] - 2023-07-24
### :sparkles: New Features
- [`1d55e84`](https://github.com/wrk-flow/larastrict/commit/1d55e847c30d14986ca3bafd0864dc8541dba7de) - **Testing**: Add AssertProviderPolicies for testing policies *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.67] - 2023-07-24
### :sparkles: New Features
- [`e99a21e`](https://github.com/wrk-flow/larastrict/commit/e99a21e6713ebf03c7931078507f4204daa8a9c5) - **Database**: Add ability to force null values to 0.0 when using FloatCast *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.66] - 2023-07-08
### :sparkles: New Features
- [`0583ac8`](https://github.com/wrk-flow/larastrict/commit/0583ac8578f639e2bf189ea977bc820567299d56) - **Database**: Add OrderByValuesScope for ordering by values in given order *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.65] - 2023-06-30
### :sparkles: New Features
- [`62869c3`](https://github.com/wrk-flow/larastrict/commit/62869c3cb8fb1733cc1bd5d9125f1c45c5269f63) - **Testing**: ModelResourceTestCase allows entity in resource *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.64] - 2023-06-30
### :boom: BREAKING CHANGES
- due to [`780f59a`](https://github.com/wrk-flow/larastrict/commit/780f59a55187f79a993699f9356065961b12f27c) - ResourceTestCase $object supports mixed type or closure *(commit by [@pionl](https://github.com/pionl))*:

  Update createResource typehint to mixed.

- due to [`e3bf3ec`](https://github.com/wrk-flow/larastrict/commit/e3bf3ecce475e816ff0572efd12f0e7ecea12c3c) - Add support for setting container to collection of resources *(commit by [@pionl](https://github.com/pionl))*:

  If you pass container and do not use JsonResource exception will be thrown.

- due to [`20b1ff4`](https://github.com/wrk-flow/larastrict/commit/20b1ff410011dd42f1f47a6047fdf7ab0fa3807b) - Move mockery to ModelResourceTestCase *(commit by [@pionl](https://github.com/pionl))*:

  ResourceTestCase does not include Mockery. Use this if needed  
  ```php  
      use MockeryPHPUnitIntegration;  
      use MockeryTestCaseSetUp;  
      protected function mockeryTestSetUp(): void  
      {  
          $this->mockModels();  
      }  
      protected function mockeryTestTearDown(): void  
      {  
      }  
  ```

- due to [`99006bf`](https://github.com/wrk-flow/larastrict/commit/99006bfd06ffc669ce6b38a59d51075b4c92c10c) - PHPStorm run for ResourceTestCase with single data entry test *(commit by [@pionl](https://github.com/pionl))*:

  to allow running single data test in PHPStorm, test function was removed.  
  To run tests add this method when extending the TestCase.  
  ```php  
      /**  
       * @param \Closure(static):void $assert  
       * @dataProvider data  
       */  
      public function test(\Closure $assert): void  
      {  
          $assert($this);  
      }  
  ```


### :sparkles: New Features
- [`3e7b7e9`](https://github.com/wrk-flow/larastrict/commit/3e7b7e9f9571f61a48156d51a1d565438f1b89ca) - **Http**: Update MessageResource to use own JsonResource *(commit by [@pionl](https://github.com/pionl))*
- [`780f59a`](https://github.com/wrk-flow/larastrict/commit/780f59a55187f79a993699f9356065961b12f27c) - **Testing**: ResourceTestCase $object supports mixed type or closure *(commit by [@pionl](https://github.com/pionl))*
- [`e3bf3ec`](https://github.com/wrk-flow/larastrict/commit/e3bf3ecce475e816ff0572efd12f0e7ecea12c3c) - **Http**: Add support for setting container to collection of resources *(commit by [@pionl](https://github.com/pionl))*
- [`20b1ff4`](https://github.com/wrk-flow/larastrict/commit/20b1ff410011dd42f1f47a6047fdf7ab0fa3807b) - **Testing**: Move mockery to ModelResourceTestCase *(commit by [@pionl](https://github.com/pionl))*
- [`34af3f0`](https://github.com/wrk-flow/larastrict/commit/34af3f0554ac70ca4cdb2ba7374cfe9e3ec61f8d) - **Http**: Add resourceArray to JsonResource/ResourceTestCase *(commit by [@pionl](https://github.com/pionl))*

### :bug: Bug Fixes
- [`99006bf`](https://github.com/wrk-flow/larastrict/commit/99006bfd06ffc669ce6b38a59d51075b4c92c10c) - **Testing**: PHPStorm run for ResourceTestCase with single data entry test *(commit by [@pionl](https://github.com/pionl))*

### :white_check_mark: Tests
- [`6a2788a`](https://github.com/wrk-flow/larastrict/commit/6a2788a62bdbe80e60f0167ce8289178a3586149) - Add test for internal resources *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.63] - 2023-06-28
### :sparkles: New Features
- [`2573fce`](https://github.com/wrk-flow/larastrict/commit/2573fce4195a112baa20c5d8ca9c89e30921f6ca) - **Http**: Add JsonResource that can create instances (with unit testing) *(commit by [@pionl](https://github.com/pionl))*
- [`882c3b5`](https://github.com/wrk-flow/larastrict/commit/882c3b566f569e851304ebde3cd1c3fae4f1d1fa) - **Testing**: Add a unit test case for quick testing of resources *(commit by [@pionl](https://github.com/pionl))*
- [`6e9a475`](https://github.com/wrk-flow/larastrict/commit/6e9a475f16e943f22ad80ead06612761987cb1aa) - **Testing**: Add ability to test models without Laravel framework *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.62] - 2023-06-27
### :bug: Bug Fixes
- [`c30fc9c`](https://github.com/wrk-flow/larastrict/commit/c30fc9ccb2917bbcd84fa99e6105d3d8334288ec) - **Testing**: Upgrade Laravel assert (construct, nullable, remove array_values) *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.61] - 2023-06-27
### :boom: BREAKING CHANGES
- due to [`acc90a9`](https://github.com/wrk-flow/larastrict/commit/acc90a92dce54ef67f483fe734e70bb4e1ecd9d0) - AssertExpectations automatically checks if expectations were called *(commit by [@pionl](https://github.com/pionl))*:

Due the changes the expectation logic has been changed and you need to update your code. How to migrate in PR #40

### :sparkles: New Features
- [`acc90a9`](https://github.com/wrk-flow/larastrict/commit/acc90a92dce54ef67f483fe734e70bb4e1ecd9d0) - **Testing**: AssertExpectations automatically checks if expectations were called *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.60] - 2023-06-23
### :sparkles: New Features
- [`b35f53d`](https://github.com/wrk-flow/larastrict/commit/b35f53d94d1ff3c5796d56ad80a0aefb1a00679d) - **Testing**: AssertEventListeners: Prevent other listeners to be fired *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.59] - 2023-06-23
### :sparkles: New Features
- [`c7b8e75`](https://github.com/wrk-flow/larastrict/commit/c7b8e753fd5e32baa7b70dcf6f22010061a95cef) - **Database**: Store database like value and add null support to FloatCast *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.58] - 2023-06-22
### :bug: Bug Fixes
- [`21c5a53`](https://github.com/wrk-flow/larastrict/commit/21c5a533cb677ba027bbb25044a657bff3b8874f) - **Testing**: Fix missing UrlGenerator and add tests *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.57] - 2023-06-22
### :sparkles: New Features
- [`d432f7b`](https://github.com/wrk-flow/larastrict/commit/d432f7b0813527505e0dcf74c284b48bfe9ef16a) - **Testing**: Add ResponseFactoryAssert *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.56] - 2023-06-22
### :sparkles: New Features
- [`b8636b8`](https://github.com/wrk-flow/larastrict/commit/b8636b8b60669919c024d46191de96151e42ac4c) - **Testing**: Add Cache RepositoryAssert *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.55] - 2023-06-21
### :sparkles: New Features
- [`8ae2d7a`](https://github.com/wrk-flow/larastrict/commit/8ae2d7a41aeaee271d00691a55170c0fc15a60c4) - **Testing**: Add ability to assert AppConfig (use AppConfigContract for implementation) *(commit by [@pionl](https://github.com/pionl))*

### :bug: Bug Fixes
- [`b0874e8`](https://github.com/wrk-flow/larastrict/commit/b0874e83eb89f2316b5c38893865cf2a80bdda61) - **Testing**: Fix MakeExpectationCommand with union returns in assert class *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.54] - 2023-06-09
### :bug: Bug Fixes
- [`4d75907`](https://github.com/wrk-flow/larastrict/commit/4d75907fbef35fb2dba1edf6f938ab48e8fb3ebc) - **Database**: Allow all Laravel 9 versions (Fix PHPStan warnings) *(commit by [@pionl](https://github.com/pionl))*
- [`8f48750`](https://github.com/wrk-flow/larastrict/commit/8f487509a314309b6c657797a58552f6c8a2698b) - **Cache**: Add @template return type to CacheMeServiceContract::get


## [v0.0.53] - 2023-06-02
### :sparkles: New Features
- [`6d89f9a`](https://github.com/wrk-flow/larastrict/commit/6d89f9ae280f73478ec36e4502b1309c9c6c09b2) - **Database**: Add float cast that supports comma *(commit by [@h4kuna](https://github.com/h4kuna))*


## [v0.0.52] - 2023-06-01
### :bug: Bug Fixes
- [`4292a8a`](https://github.com/wrk-flow/larastrict/commit/4292a8a578a0a77aa72d608a46aed977c53b0418) - **Rules**: Improve NumberRule range of supported int/float values *(commit by [@h4kuna](https://github.com/h4kuna))*


## [v0.0.51] - 2023-05-25
### :bug: Bug Fixes
- [`a54eeb4`](https://github.com/wrk-flow/larastrict/commit/a54eeb49248d41794fd943a127d5d518cb544d41) - **Queue**: Correctly ensure that queue is not overridden when using property *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.50] - 2023-05-25
### :bug: Bug Fixes
- [`4844918`](https://github.com/wrk-flow/larastrict/commit/4844918256ff68f7a4c68d93fdef894d080cdc85) - **Queue**: Ensure that queue is not overridden when using property *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.49] - 2023-05-19
### :boom: BREAKING CHANGES
- due to [`1742fcf`](https://github.com/wrk-flow/larastrict/commit/1742fcf9abd099124ddb30d55ace8557267dbe28) - Allow array arguments in queued command *(commit by [@pionl](https://github.com/pionl))*:

  low - ScheduleServiceService renamed to ScheduleService


### :bug: Bug Fixes
- [`1742fcf`](https://github.com/wrk-flow/larastrict/commit/1742fcf9abd099124ddb30d55ace8557267dbe28) - **Schedule**: Allow array arguments in queued command *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.48] - 2023-05-12
### :bug: Bug Fixes
- [`ec40840`](https://github.com/wrk-flow/larastrict/commit/ec40840d0aafb66034e08a1ecbc38c61d5b6c381) - **Database**: Fix PHPStan with scopes parameter in missing methods *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.47] - 2023-05-11
### :bug: Bug Fixes
- [`2e9e6fe`](https://github.com/wrk-flow/larastrict/commit/2e9e6feb82a3078cfae28c99f7049d972502c814) - **Database**: Fix PHPStan with scopes parameter *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.46] - 2023-05-04
### :sparkles: New Features
- [`07ea6d0`](https://github.com/wrk-flow/larastrict/commit/07ea6d0c4745c17129784a00324f6a0db8c00907) - **Log**: Add extra line for line/debug *(commit by [@pionl](https://github.com/pionl))*
- [`1eed371`](https://github.com/wrk-flow/larastrict/commit/1eed371562a46b3fa0a9f89a090a0dd6be54990b) - **Log**: Do not show debug lines if verbosity is normal, hide output on quiet *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.45] - 2023-05-02
### :wrench: Chores
- [`757942a`](https://github.com/wrk-flow/larastrict/commit/757942a2b4ccaff1532bb41e3bfe65ab9ac6a8d5) - **Console**: Add extra space after writing context in twoDetailColumns *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.44] - 2023-05-02
### :boom: BREAKING CHANGES
- due to [`30e3a0c`](https://github.com/wrk-flow/larastrict/commit/30e3a0c76314bb78d3d9cd7762949506241506d1) - Add ability to turn of log for get/set method *(commit by [@pionl](https://github.com/pionl))*:

  If you are extending CacheMeServiceContract then add new last parameter `bool $log = true` to set/get method.

- due to [`0b1d41d`](https://github.com/wrk-flow/larastrict/commit/0b1d41de5aa66ee55cc21b14bfcecbb8ed74251b) - Add ability to output LogInterface usage to console. *(commit by [@pionl](https://github.com/pionl))*:

  LogToOutputService and LoggerToOutputCommand removed (was not working).


### :sparkles: New Features
- [`30e3a0c`](https://github.com/wrk-flow/larastrict/commit/30e3a0c76314bb78d3d9cd7762949506241506d1) - **Cache**: Add ability to turn of log for get/set method *(commit by [@pionl](https://github.com/pionl))*
- [`449ba5c`](https://github.com/wrk-flow/larastrict/commit/449ba5c158618bc869ab965d58effe3ca1bced7d) - **Config**: Add ability to set value *(commit by [@pionl](https://github.com/pionl))*
- [`1c5c1c7`](https://github.com/wrk-flow/larastrict/commit/1c5c1c714ca36d361477f0f52b0f790590ea6e23) - **Config**: Add ability to provider app service provider config *(commit by [@pionl](https://github.com/pionl))*
- [`1c5970b`](https://github.com/wrk-flow/larastrict/commit/1c5970b08353d3e25d2d306c398f528f86ee959f) - **Docker**: Add proper docker support for schedule (needs to be enabled) *(commit by [@pionl](https://github.com/pionl))*
- [`0b1d41d`](https://github.com/wrk-flow/larastrict/commit/0b1d41de5aa66ee55cc21b14bfcecbb8ed74251b) - **Console**: Add ability to output LogInterface usage to console. *(commit by [@pionl](https://github.com/pionl))*

### :wrench: Chores
- [`69a3337`](https://github.com/wrk-flow/larastrict/commit/69a3337e412fe0fb660c8ec25044199d70583802) - **Actions**: Improve github actions *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.43] - 2023-04-26
### :wrench: Chores
- [`575966f`](https://github.com/wrk-flow/larastrict/commit/575966f14e80e569ae82e0d707bccb02f9f29753) - Fix incorrect package repository/homepage/name + update checkout to v3 *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.42] - 2023-04-26
### :wrench: Chores
- [`0d98c88`](https://github.com/wrk-flow/larastrict/commit/0d98c88bbdd69ec737a25c65e3afe91496061366) - Introduce EditorConfig *(commit by [@szepeviktor](https://github.com/szepeviktor))*
- [`77197b7`](https://github.com/wrk-flow/larastrict/commit/77197b7305f71102fb36711bf103596156a9f42c) - Fix Markdown list *(commit by [@szepeviktor](https://github.com/szepeviktor))*
- [`a2f308d`](https://github.com/wrk-flow/larastrict/commit/a2f308d800df9e1fee02d4d61325d4af2bd6a596) - Run lint + fix test *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.41] - 2023-01-20
### :sparkles: New Features
- [`6c8d651`](https://github.com/wrk-flow/larastrict/commit/6c8d65152acb1a36ad734901c2c5309928a96679) - **Testing**: Add guard assert *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.40] - 2023-01-18
### :sparkles: New Features
- [`b0ec6a8`](https://github.com/wrk-flow/larastrict/commit/b0ec6a85b6994e98dfdf73df6f7ac22cd4905561) - **Testing**: Fix PHPStan warning when using null in multi function asserts *(commit by [@pionl](https://github.com/pionl))*
- [`c674c4b`](https://github.com/wrk-flow/larastrict/commit/c674c4b6d21a5f25a55f6498ed330cc8e6fedb1b) - **Testing**: Add TranslatorAssert for asserting translations *(commit by [@pionl](https://github.com/pionl))*
- [`e02c81b`](https://github.com/wrk-flow/larastrict/commit/e02c81b89beb56e81479f31781993c44196171d7) - **Http**: Add ability to return custom public message in json / views *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.39] - 2023-01-16
### :boom: BREAKING CHANGES
- due to [`1428244`](https://github.com/wrk-flow/larastrict/commit/14282447eceaa2b74db1af14e50a9d19a8f6f9e4) - Add support for multiple listeners in assertEventListeners *(commit by [@pionl](https://github.com/pionl))*:

  assertEventListeners accepts list of contracts and their assert listener


### :sparkles: New Features
- [`1428244`](https://github.com/wrk-flow/larastrict/commit/14282447eceaa2b74db1af14e50a9d19a8f6f9e4) - **Testing**: Add support for multiple listeners in assertEventListeners *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.38] - 2023-01-16
### :sparkles: New Features
- [`4d0e39e`](https://github.com/wrk-flow/larastrict/commit/4d0e39e452f4cb28bfe5c1be135f022fe469155e) - **Testing**: Add ability to assert event listeners with assert class *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.37] - 2023-01-12
### :boom: BREAKING CHANGES
- due to [`e69f381`](https://github.com/wrk-flow/larastrict/commit/e69f381ec92f3535ffeb667071d871ab5e0254fd) - Add getOptional method to allow return null if translation is not set + support arrayable keys *(commit by [@pionl](https://github.com/pionl))*:

  AbstractTranslations: $key parameter in methods get/getChoice/getArray/getKey accepts string|array instead of string


### :sparkles: New Features
- [`e69f381`](https://github.com/wrk-flow/larastrict/commit/e69f381ec92f3535ffeb667071d871ab5e0254fd) - **Translations**: Add getOptional method to allow return null if translation is not set + support arrayable keys *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.36] - 2022-12-23
### :boom: BREAKING CHANGES
- due to [`022b496`](https://github.com/wrk-flow/larastrict/commit/022b49612c942ac7aea0deb309d1596b9c3fb360) - ContextServiceContractGetExpectation createState removed and add ability to assert passed $createState *(commit by [@pionl](https://github.com/pionl))*:

  ContextServiceContractGetExpectation createState removed and add ability to assert passed $createState


### :sparkles: New Features
- [`022b496`](https://github.com/wrk-flow/larastrict/commit/022b49612c942ac7aea0deb309d1596b9c3fb360) - **Testing**: ContextServiceContractGetExpectation createState removed and add ability to assert passed $createState *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.35] - 2022-12-23
### :sparkles: New Features
- [`7a942e0`](https://github.com/wrk-flow/larastrict/commit/7a942e05dffbc8acb5705c9301bae02222d94414) - **Testing**: Context getExpectation createState property is optional due the fact its not needed *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.34] - 2022-12-22
### :boom: BREAKING CHANGES
- due to [`4f8557c`](https://github.com/wrk-flow/larastrict/commit/4f8557ceef282842c75466d13f75347c20156d7d) - Add and use ContextServiceContract instead of a implementation class + improve phpstan support *(commit by [@pionl](https://github.com/pionl))*:

  AbstractContext uses ContextServiceContract instead of a class.


### :sparkles: New Features
- [`a904884`](https://github.com/wrk-flow/larastrict/commit/a90488419b0158b561a6507a6fc37964115f5e73) - **Core**: Make ImplementsService a singleton *(commit by [@pionl](https://github.com/pionl))*
- [`7dfab17`](https://github.com/wrk-flow/larastrict/commit/7dfab17865c580d4657449a3ddacec9085641ab7) - **Testing**: Add ability to run call closures in TestingContainer *(commit by [@pionl](https://github.com/pionl))*
- [`4f8557c`](https://github.com/wrk-flow/larastrict/commit/4f8557ceef282842c75466d13f75347c20156d7d) - **Context**: Add and use ContextServiceContract instead of a implementation class + improve phpstan support *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.33] - 2022-12-19
### :boom: BREAKING CHANGES
- due to [`25b420d`](https://github.com/wrk-flow/larastrict/commit/25b420da3b5a8f6dde38707d9a4db9ea4134e9fa) - Adjust convention for boot pipes - use Boot prefix *(commit by [@pionl](https://github.com/pionl))*:

  Low conflict - Renamed LoadProviderRoutes Pipe to BootProviderRoutesPipe,  
  LoadProviderViewComponents Pipe to BootProviderViewComponents and  
  RegisterProviderPoliciesPipe to BootProviderPoliciesPipe


### :sparkles: New Features
- [`550ac67`](https://github.com/wrk-flow/larastrict/commit/550ac676597e63a6ff60781705615aa3543296c8) - **Testing**: Add asserts for View and View\\Factory contracts *(commit by [@pionl](https://github.com/pionl))*
- [`44d355e`](https://github.com/wrk-flow/larastrict/commit/44d355e6c8c7ee71c81147e238b197b32808c889) - **Testing**: Add assertCalled method for asserting if expectations were called *(commit by [@pionl](https://github.com/pionl))*
- [`d05eb61`](https://github.com/wrk-flow/larastrict/commit/d05eb61b8fcaa889f5c3a73570f1a5e3ba535f08) - **Provider**: Add ability to boot view composers using HasViewComposers interface *(commit by [@pionl](https://github.com/pionl))*

### :recycle: Refactors
- [`25b420d`](https://github.com/wrk-flow/larastrict/commit/25b420da3b5a8f6dde38707d9a4db9ea4134e9fa) - **Providers**: Adjust convention for boot pipes - use Boot prefix *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.32] - 2022-12-15
### :bug: Bug Fixes
- [`e62f54a`](https://github.com/wrk-flow/larastrict/commit/e62f54abf82cc450c8e9a257dd15a286cb944b32) - **Testing**: Fix assert hook generation without method parameters *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.31] - 2022-12-14
### :bug: Bug Fixes
- [`624eea0`](https://github.com/wrk-flow/larastrict/commit/624eea06fae2d4506f383bb3e99c3f6bdbdcf10f) - **Testing**: Fix generating hook parameters for no parameter method *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.30] - 2022-12-14
### :boom: BREAKING CHANGES
- due to [`84a913a`](https://github.com/wrk-flow/larastrict/commit/84a913a9f8266d59d5d7e0f8299b36bf937706ad) - Pass method parameters to expectation hook. *(commit by [@pionl](https://github.com/pionl))*:

  hook closure now receives more properties (expectation is last).


### :sparkles: New Features
- [`84a913a`](https://github.com/wrk-flow/larastrict/commit/84a913a9f8266d59d5d7e0f8299b36bf937706ad) - **Testing**: Pass method parameters to expectation hook. *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.29] - 2022-12-14
### :sparkles: New Features
- [`d5b06d9`](https://github.com/wrk-flow/larastrict/commit/d5b06d95e8153f4f4cb226c382524b0e6080a2ba) - **Testing**: Add ability to run hook on assert expectation *(commit by [@pionl](https://github.com/pionl))*
- [`56e2e7e`](https://github.com/wrk-flow/larastrict/commit/56e2e7e00185f76bb18bca95dd83b5aa19fa847b) - **Testing**: Commit SimpleActionContract assert for tests *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.28] - 2022-12-13
### :sparkles: New Features
- [`5ea6f2c`](https://github.com/wrk-flow/larastrict/commit/5ea6f2cf11d0833351baaa6aac0a525cd423fe9c) - **Testing**: Add assert / expectation for CacheMeService *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.27] - 2022-12-09
### :sparkles: New Features
- [`3b1984f`](https://github.com/wrk-flow/larastrict/commit/3b1984f9c9ce25fd7db69397ec071bb21789e44a) - **Testing**: Add Bus dispatcher assert / expectation *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.26] - 2022-11-29
### :sparkles: New Features
- [`0ddebb8`](https://github.com/wrk-flow/larastrict/commit/0ddebb817761e7f2f5dc7652ecc4a2853e4db455) - **User**: Add ability to auto login a user via Auto-Login header in local environment *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.25] - 2022-11-28
### :sparkles: New Features
- [`e062fe4`](https://github.com/wrk-flow/larastrict/commit/e062fe4d78402797166e32697bcba0a1b86187e4) - **Database**: Move getScopedQuery to AbstractQuery *(commit by [@pionl](https://github.com/pionl))*


## [v0.0.24] - 2022-11-24
### :boom: BREAKING CHANGES
- due to [`b5852d7`](https://github.com/wrk-flow/larastrict/commit/b5852d774719e5c15bb8d37a72b78b9b18e06e49) - Add ability to change queue for queued commands *(commit by [@pionl](https://github.com/pionl))*:

  minor impact, scheduleServiceContract contains new parameter `string $queue = 'default'`


### :sparkles: New Features
- [`b5852d7`](https://github.com/wrk-flow/larastrict/commit/b5852d774719e5c15bb8d37a72b78b9b18e06e49) - **Console**: Add ability to change queue for queued commands *(commit by [@pionl](https://github.com/pionl))*


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
[v0.0.24]: https://github.com/wrk-flow/larastrict/compare/v0.0.23...v0.0.24
[v0.0.25]: https://github.com/wrk-flow/larastrict/compare/v0.0.24...v0.0.25
[v0.0.26]: https://github.com/wrk-flow/larastrict/compare/v0.0.25...v0.0.26
[v0.0.27]: https://github.com/wrk-flow/larastrict/compare/v0.0.26...v0.0.27
[v0.0.28]: https://github.com/wrk-flow/larastrict/compare/v0.0.27...v0.0.28
[v0.0.29]: https://github.com/wrk-flow/larastrict/compare/v0.0.28...v0.0.29
[v0.0.30]: https://github.com/wrk-flow/larastrict/compare/v0.0.29...v0.0.30
[v0.0.31]: https://github.com/wrk-flow/larastrict/compare/v0.0.30...v0.0.31
[v0.0.32]: https://github.com/wrk-flow/larastrict/compare/v0.0.31...v0.0.32
[v0.0.33]: https://github.com/wrk-flow/larastrict/compare/v0.0.32...v0.0.33
[v0.0.34]: https://github.com/wrk-flow/larastrict/compare/v0.0.33...v0.0.34
[v0.0.35]: https://github.com/wrk-flow/larastrict/compare/v0.0.34...v0.0.35
[v0.0.36]: https://github.com/wrk-flow/larastrict/compare/v0.0.35...v0.0.36
[v0.0.37]: https://github.com/wrk-flow/larastrict/compare/v0.0.36...v0.0.37
[v0.0.38]: https://github.com/wrk-flow/larastrict/compare/v0.0.37...v0.0.38
[v0.0.39]: https://github.com/wrk-flow/larastrict/compare/v0.0.38...v0.0.39
[v0.0.40]: https://github.com/wrk-flow/larastrict/compare/v0.0.39...v0.0.40
[v0.0.41]: https://github.com/wrk-flow/larastrict/compare/v0.0.40...v0.0.41

[v0.0.42]: https://github.com/wrk-flow/larastrict/compare/v0.0.41...v0.0.42
[v0.0.43]: https://github.com/wrk-flow/larastrict/compare/v0.0.42...v0.0.43
[v0.0.44]: https://github.com/wrk-flow/larastrict/compare/v0.0.43...v0.0.44
[v0.0.45]: https://github.com/wrk-flow/larastrict/compare/v0.0.44...v0.0.45
[v0.0.46]: https://github.com/wrk-flow/larastrict/compare/v0.0.45...v0.0.46
[v0.0.47]: https://github.com/wrk-flow/larastrict/compare/v0.0.46...v0.0.47
[v0.0.48]: https://github.com/wrk-flow/larastrict/compare/v0.0.47...v0.0.48
[v0.0.49]: https://github.com/wrk-flow/larastrict/compare/v0.0.48...v0.0.49
[v0.0.50]: https://github.com/wrk-flow/larastrict/compare/v0.0.49...v0.0.50
[v0.0.51]: https://github.com/wrk-flow/larastrict/compare/v0.0.50...v0.0.51
[v0.0.52]: https://github.com/wrk-flow/larastrict/compare/v0.0.51...v0.0.52
[v0.0.53]: https://github.com/wrk-flow/larastrict/compare/v0.0.52...v0.0.53
[v0.0.54]: https://github.com/wrk-flow/larastrict/compare/v0.0.53...v0.0.54

[v0.0.55]: https://github.com/wrk-flow/larastrict/compare/v0.0.54...v0.0.55
[v0.0.56]: https://github.com/wrk-flow/larastrict/compare/v0.0.55...v0.0.56
[v0.0.57]: https://github.com/wrk-flow/larastrict/compare/v0.0.56...v0.0.57
[v0.0.58]: https://github.com/wrk-flow/larastrict/compare/v0.0.57...v0.0.58
[v0.0.59]: https://github.com/wrk-flow/larastrict/compare/v0.0.58...v0.0.59
[v0.0.60]: https://github.com/wrk-flow/larastrict/compare/v0.0.59...v0.0.60
[v0.0.61]: https://github.com/wrk-flow/larastrict/compare/v0.0.60...v0.0.61
[v0.0.62]: https://github.com/wrk-flow/larastrict/compare/v0.0.61...v0.0.62

[v0.0.63]: https://github.com/wrk-flow/larastrict/compare/v0.0.62...v0.0.63
[v0.0.64]: https://github.com/wrk-flow/larastrict/compare/v0.0.63...v0.0.64
[v0.0.65]: https://github.com/wrk-flow/larastrict/compare/v0.0.64...v0.0.65
[v0.0.66]: https://github.com/wrk-flow/larastrict/compare/v0.0.65...v0.0.66
[v0.0.67]: https://github.com/wrk-flow/larastrict/compare/v0.0.66...v0.0.67
[v0.0.68]: https://github.com/wrk-flow/larastrict/compare/v0.0.67...v0.0.68
[v0.0.69]: https://github.com/wrk-flow/larastrict/compare/v0.0.68...v0.0.69

[v0.0.70]: https://github.com/wrk-flow/larastrict/compare/v0.0.69...v0.0.70
[v0.0.71]: https://github.com/wrk-flow/larastrict/compare/v0.0.70...v0.0.71
[v0.0.72]: https://github.com/wrk-flow/larastrict/compare/v0.0.71...v0.0.72
[v0.0.73]: https://github.com/wrk-flow/larastrict/compare/v0.0.72...v0.0.73
[v0.0.74]: https://github.com/wrk-flow/larastrict/compare/v0.0.73...v0.0.74
[v0.0.75]: https://github.com/wrk-flow/larastrict/compare/v0.0.74...v0.0.75
[v0.0.76]: https://github.com/wrk-flow/larastrict/compare/v0.0.75...v0.0.76
[v0.0.77]: https://github.com/wrk-flow/larastrict/compare/v0.0.76...v0.0.77
[v0.0.78]: https://github.com/wrk-flow/larastrict/compare/v0.0.77...v0.0.78
[v0.0.79]: https://github.com/wrk-flow/larastrict/compare/v0.0.78...v0.0.79
[v0.0.80]: https://github.com/wrk-flow/larastrict/compare/v0.0.79...v0.0.80
[v0.0.81]: https://github.com/wrk-flow/larastrict/compare/v0.0.80...v0.0.81
[v0.0.82]: https://github.com/wrk-flow/larastrict/compare/v0.0.81...v0.0.82
[v0.0.83]: https://github.com/wrk-flow/larastrict/compare/v0.0.82...v0.0.83
[v0.0.84]: https://github.com/wrk-flow/larastrict/compare/v0.0.83...v0.0.84
[v0.0.85]: https://github.com/wrk-flow/larastrict/compare/v0.0.84...v0.0.85
[v0.0.86]: https://github.com/wrk-flow/larastrict/compare/v0.0.85...v0.0.86
