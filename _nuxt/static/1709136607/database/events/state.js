window.__NUXT__=(function(a,b,c,d,e,f,g,h,i){return {staticAssetsBase:"\u002F_nuxt\u002Fstatic\u002F1709136607",layout:"default",error:d,state:{categories:{en:{"":[{slug:"console",title:"Console",to:"\u002Fconsole",category:a},{slug:"docker",title:"Docker",to:"\u002Fdocker",category:a},{slug:e,title:"Introduction",to:f,category:a},{slug:"logging",title:"Logging",to:"\u002Flogging",category:a},{slug:"service-provider",title:"Service provider",to:"\u002Fservice-provider",category:a},{slug:"testing",title:"Testing",to:"\u002Ftesting",category:a}],API:[{slug:"health",title:"Health",category:"API",to:"\u002Fapi\u002Fhealth"}],Core:[{slug:"core",title:"Actions",category:"Core",to:"\u002Fcore\u002Fcore"}],Database:[{slug:"events",title:"Events",category:b,to:g},{slug:"migrations",title:"Migrations",category:b,to:"\u002Fdatabase\u002Fmigrations"},{slug:e,title:b,category:b,to:"\u002Fdatabase\u002F"},{slug:"models",title:"Models",category:b,to:"\u002Fdatabase\u002Fmodels"},{slug:"queries",title:"Queries",category:b,to:"\u002Fdatabase\u002Fqueries"},{slug:"scopes",title:"Scopes",category:b,to:"\u002Fdatabase\u002Fscopes"}],Community:[{slug:"releases",title:"Releases",category:"Community",to:"\u002Freleases"}]}},releases:[{name:"v0.0.79",date:"2024-02-28T16:09:07Z",body:"\u003Ch3 id=\"bug-bug-fixes\"\u003E:bug: Bug Fixes\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F28cfde81c8f6ecfd65acce29fbe10adf5f0e5ef8\"\u003E\u003Ccode\u003E28cfde8\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003EQueue\u003C\u002Fstrong\u003E: Add missing $method parameter to RunJobActionContract \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.78",date:"2024-02-28T15:31:52Z",body:"\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F046a9e32ef4cfeb5a1d05f73aab6153e300956cf\"\u003E\u003Ccode\u003E046a9e3\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003EQueue\u003C\u002Fstrong\u003E: Add ability to dispatch job in testable way \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.77",date:"2024-02-06T10:53:42Z",body:"\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fe2eb67978ad676af2deddedfd3cb60e8333da41a\"\u003E\u003Ccode\u003Ee2eb679\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ECacheMeService\u003C\u002Fstrong\u003E: ttl defined like seconds instead of minutes \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.76",date:"2023-12-11T15:43:54Z",body:"\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F9a1ddb68435d0b04f86c1c184e6e78f12a9318f6\"\u003E\u003Ccode\u003E9a1ddb6\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003EServiceProvider\u003C\u002Fstrong\u003E: Add ability to get tagged classes of given implementation \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.75",date:"2023-12-10T16:05:09Z",body:"\u003Ch3 id=\"boom-breaking-changes\"\u003E:boom: BREAKING CHANGES\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Cp\u003Edue to \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F7804785c13ad12e10b3e8da85ed47ae4341469ca\"\u003E\u003Ccode\u003E7804785\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - Improve PHPStan support for ContextEventsService \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E:\u003C\u002Fp\u003E\n\u003Cp\u003EDropped Closure event due the bad type usage\u003C\u002Fp\u003E\n\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F7804785c13ad12e10b3e8da85ed47ae4341469ca\"\u003E\u003Ccode\u003E7804785\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003EContext\u003C\u002Fstrong\u003E: Improve PHPStan support for ContextEventsService \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.74",date:"2023-11-22T17:28:30Z",body:"\u003Ch3 id=\"boom-breaking-changes\"\u003E:boom: BREAKING CHANGES\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Cp\u003Edue to \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fdcb79f34653cfbb32a5d1dbd13c726704b665457\"\u003E\u003Ccode\u003Edcb79f3\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - OrderByValuesScope is now from ASC to DESC order of given values \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E:\u003C\u002Fp\u003E\n\u003Cp\u003EValues must be ordered from prefered order to last wanted order (now it was incorrectly used)\u003C\u002Fp\u003E\n\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Ch3 id=\"bug-bug-fixes\"\u003E:bug: Bug Fixes\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fdcb79f34653cfbb32a5d1dbd13c726704b665457\"\u003E\u003Ccode\u003Edcb79f3\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003EDatabase\u003C\u002Fstrong\u003E: OrderByValuesScope is now from ASC to DESC order of given values \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.73",date:"2023-11-16T09:37:06Z",body:"\u003Ch3 id=\"bug-bug-fixes\"\u003E:bug: Bug Fixes\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fc6447853ab3aca2cdb74cae8c980ec2f94980f8d\"\u003E\u003Ccode\u003Ec644785\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: Internal variables for generated assert has prefix underscore \u003Cem\u003E(commit by @h4kuna)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.72",date:"2023-11-11T12:39:18Z",body:"\u003Ch3 id=\"bug-bug-fixes\"\u003E:bug: Bug Fixes\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F942323d97554c7430af50b4a742a7dbc323c13ff\"\u003E\u003Ccode\u003E942323d\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: Fix assert listener when closure listener is registered \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.71",date:"2023-10-12T14:20:41Z",body:"\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fe20cea1b6107d325b7ca703cd7d98b28959e5a0f\"\u003E\u003Ccode\u003Ee20cea1\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ECore\u003C\u002Fstrong\u003E: Add contract for sleep service with no sleep implementation in tests \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.70",date:"2023-09-05T18:26:20Z",body:"\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F60da0a8623e63428a72c6fcb218dcb88403510af\"\u003E\u003Ccode\u003E60da0a8\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: GateAssert-&gt;authorize now throws exception if false response is returned \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F872fe0c8fe9b0e036332aef25cc98fb8a31d76f1\"\u003E\u003Ccode\u003E872fe0c\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: CreateRequest now accept user parameter that is passed to request \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.69",date:"2023-07-24T15:40:58Z",body:"\u003Ch3 id=\"boom-breaking-changes\"\u003E:boom: BREAKING CHANGES\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Cp\u003Edue to \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fecbd60b80eda06fc18a5ac4dd866ae8d6f8490ad\"\u003E\u003Ccode\u003Eecbd60b\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - Add ability to create request without Laravel container \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E:\u003C\u002Fp\u003E\n\u003Cp\u003EcreatePostRequest has been renamed to createAndValidateRequest\u003C\u002Fp\u003E\n\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fab64cfae0f90e2876236c31519ea8bf17c83bb66\"\u003E\u003Ccode\u003Eab64cfa\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: Move MockModels to Testing\u002FConcerns namespace \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fecbd60b80eda06fc18a5ac4dd866ae8d6f8490ad\"\u003E\u003Ccode\u003Eecbd60b\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: Add ability to create request without Laravel container \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.68",date:"2023-07-24T13:40:43Z",body:"\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F1d55e847c30d14986ca3bafd0864dc8541dba7de\"\u003E\u003Ccode\u003E1d55e84\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: Add AssertProviderPolicies for testing policies \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.67",date:"2023-07-24T09:37:52Z",body:"\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fe99a21e6713ebf03c7931078507f4204daa8a9c5\"\u003E\u003Ccode\u003Ee99a21e\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003EDatabase\u003C\u002Fstrong\u003E: Add ability to force null values to 0.0 when using FloatCast \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.66",date:"2023-07-08T15:18:51Z",body:"\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F0583ac8578f639e2bf189ea977bc820567299d56\"\u003E\u003Ccode\u003E0583ac8\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003EDatabase\u003C\u002Fstrong\u003E: Add OrderByValuesScope for ordering by values in given order \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.65",date:"2023-06-30T14:30:39Z",body:"\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F62869c3cb8fb1733cc1bd5d9125f1c45c5269f63\"\u003E\u003Ccode\u003E62869c3\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: ModelResourceTestCase allows entity in resource \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.64",date:"2023-06-30T07:56:15Z",body:"\u003Ch3 id=\"boom-breaking-changes\"\u003E:boom: BREAKING CHANGES\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Cp\u003Edue to \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F780f59a55187f79a993699f9356065961b12f27c\"\u003E\u003Ccode\u003E780f59a\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - ResourceTestCase $object supports mixed type or closure \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E:\u003C\u002Fp\u003E\n\u003Cp\u003EUpdate createResource typehint to mixed.\u003C\u002Fp\u003E\n\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Cp\u003Edue to \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fe3bf3ecce475e816ff0572efd12f0e7ecea12c3c\"\u003E\u003Ccode\u003Ee3bf3ec\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - Add support for setting container to collection of resources \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E:\u003C\u002Fp\u003E\n\u003Cp\u003EIf you pass container and do not use JsonResource exception will be thrown.\u003C\u002Fp\u003E\n\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Cp\u003Edue to \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F20b1ff410011dd42f1f47a6047fdf7ab0fa3807b\"\u003E\u003Ccode\u003E20b1ff4\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - Move mockery to ModelResourceTestCase \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E:\u003C\u002Fp\u003E\n\u003Cp\u003EResourceTestCase does not include Mockery. Use this if needed  \u003C\u002Fp\u003E\n\u003Cpre\u003E\u003Ccode class=\"language-php\"\u003E    use MockeryPHPUnitIntegration;  \n    use MockeryTestCaseSetUp;  \n    protected function mockeryTestSetUp(): void  \n    {  \n        $this-&gt;mockModels();  \n    }  \n    protected function mockeryTestTearDown(): void  \n    {  \n    }  \n\u003C\u002Fcode\u003E\u003C\u002Fpre\u003E\n\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Cp\u003Edue to \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F99006bfd06ffc669ce6b38a59d51075b4c92c10c\"\u003E\u003Ccode\u003E99006bf\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - PHPStorm run for ResourceTestCase with single data entry test \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E:\u003C\u002Fp\u003E\n\u003Cp\u003Eto allow running single data test in PHPStorm, test function was removed.\u003Cbr\u003ETo run tests add this method when extending the TestCase.  \u003C\u002Fp\u003E\n\u003Cpre\u003E\u003Ccode class=\"language-php\"\u003E    \u002F**  \n     * @param \\Closure(static):void $assert  \n     * @dataProvider data  \n     *\u002F  \n    public function test(\\Closure $assert): void  \n    {  \n        $assert($this);  \n    }  \n\u003C\u002Fcode\u003E\u003C\u002Fpre\u003E\n\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F3e7b7e9f9571f61a48156d51a1d565438f1b89ca\"\u003E\u003Ccode\u003E3e7b7e9\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003EHttp\u003C\u002Fstrong\u003E: Update MessageResource to use own JsonResource \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F780f59a55187f79a993699f9356065961b12f27c\"\u003E\u003Ccode\u003E780f59a\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: ResourceTestCase $object supports mixed type or closure \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fe3bf3ecce475e816ff0572efd12f0e7ecea12c3c\"\u003E\u003Ccode\u003Ee3bf3ec\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003EHttp\u003C\u002Fstrong\u003E: Add support for setting container to collection of resources \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F20b1ff410011dd42f1f47a6047fdf7ab0fa3807b\"\u003E\u003Ccode\u003E20b1ff4\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: Move mockery to ModelResourceTestCase \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F34af3f0554ac70ca4cdb2ba7374cfe9e3ec61f8d\"\u003E\u003Ccode\u003E34af3f0\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003EHttp\u003C\u002Fstrong\u003E: Add resourceArray to JsonResource\u002FResourceTestCase \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Ch3 id=\"bug-bug-fixes\"\u003E:bug: Bug Fixes\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F99006bfd06ffc669ce6b38a59d51075b4c92c10c\"\u003E\u003Ccode\u003E99006bf\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: PHPStorm run for ResourceTestCase with single data entry test \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Ch3 id=\"white_check_mark-tests\"\u003E:white_check_mark: Tests\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F6a2788a62bdbe80e60f0167ce8289178a3586149\"\u003E\u003Ccode\u003E6a2788a\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - Add test for internal resources \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.63",date:"2023-06-28T19:29:15Z",body:"\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F2573fce4195a112baa20c5d8ca9c89e30921f6ca\"\u003E\u003Ccode\u003E2573fce\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003EHttp\u003C\u002Fstrong\u003E: Add JsonResource that can create instances (with unit testing) \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F882c3b566f569e851304ebde3cd1c3fae4f1d1fa\"\u003E\u003Ccode\u003E882c3b5\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: Add a unit test case for quick testing of resources \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F6e9a475f16e943f22ad80ead06612761987cb1aa\"\u003E\u003Ccode\u003E6e9a475\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: Add ability to test models without Laravel framework \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.62",date:"2023-06-27T20:21:28Z",body:"\u003Ch3 id=\"bug-bug-fixes\"\u003E:bug: Bug Fixes\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fc30fc9ccb2917bbcd84fa99e6105d3d8334288ec\"\u003E\u003Ccode\u003Ec30fc9c\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: Upgrade Laravel assert (construct, nullable, remove array_values) \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.61",date:"2023-06-27T16:46:44Z",body:"\u003Ch3 id=\"boom-breaking-changes\"\u003E:boom: BREAKING CHANGES\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003Edue to \u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Facc90a92dce54ef67f483fe734e70bb4e1ecd9d0\"\u003E\u003Ccode\u003Eacc90a9\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - AssertExpectations automatically checks if expectations were called \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E:\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Cp\u003EDue the changes the expectation logic has been changed and you need to update your code. How to migrate in PR #40\u003C\u002Fp\u003E\n\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Facc90a92dce54ef67f483fe734e70bb4e1ecd9d0\"\u003E\u003Ccode\u003Eacc90a9\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: AssertExpectations automatically checks if expectations were called \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.60",date:"2023-06-23T15:09:17Z",body:"\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fb35f53d94d1ff3c5796d56ad80a0aefb1a00679d\"\u003E\u003Ccode\u003Eb35f53d\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: AssertEventListeners: Prevent other listeners to be fired \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.59",date:"2023-06-23T13:12:39Z",body:"\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fc7b8e753fd5e32baa7b70dcf6f22010061a95cef\"\u003E\u003Ccode\u003Ec7b8e75\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003EDatabase\u003C\u002Fstrong\u003E: Store database like value and add null support to FloatCast \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.58",date:"2023-06-22T13:32:18Z",body:"\u003Ch3 id=\"bug-bug-fixes\"\u003E:bug: Bug Fixes\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F21c5a533cb677ba027bbb25044a657bff3b8874f\"\u003E\u003Ccode\u003E21c5a53\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: Fix missing UrlGenerator and add tests \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.57",date:"2023-06-22T11:35:43Z",body:"\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fd432f7b0813527505e0dcf74c284b48bfe9ef16a\"\u003E\u003Ccode\u003Ed432f7b\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: Add ResponseFactoryAssert \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.56",date:"2023-06-22T08:58:13Z",body:"\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fb8636b8b60669919c024d46191de96151e42ac4c\"\u003E\u003Ccode\u003Eb8636b8\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: Add Cache RepositoryAssert \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.55",date:"2023-06-21T15:28:45Z",body:"\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F8ae2d7a41aeaee271d00691a55170c0fc15a60c4\"\u003E\u003Ccode\u003E8ae2d7a\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: Add ability to assert AppConfig (use AppConfigContract for implementation) \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n\u003Ch3 id=\"bug-bug-fixes\"\u003E:bug: Bug Fixes\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fb0874e83eb89f2316b5c38893865cf2a80bdda61\"\u003E\u003Ccode\u003Eb0874e8\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ETesting\u003C\u002Fstrong\u003E: Fix MakeExpectationCommand with union returns in assert class \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.54",date:"2023-06-09T09:40:11Z",body:"\u003Ch3 id=\"bug-bug-fixes\"\u003E:bug: Bug Fixes\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F4d75907fbef35fb2dba1edf6f938ab48e8fb3ebc\"\u003E\u003Ccode\u003E4d75907\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003EDatabase\u003C\u002Fstrong\u003E: Allow all Laravel 9 versions (Fix PHPStan warnings) \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F8f487509a314309b6c657797a58552f6c8a2698b\"\u003E\u003Ccode\u003E8f48750\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ECache\u003C\u002Fstrong\u003E: Add \u003Ccode\u003E@template\u003C\u002Fcode\u003E return type to CacheMeServiceContract::get  \u003Cem\u003E(commit by @h4kuna )\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.53",date:"2023-06-02T10:30:37Z",body:"\u003Ch3 id=\"sparkles-new-features\"\u003E:sparkles: New Features\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F6d89f9ae280f73478ec36e4502b1309c9c6c09b2\"\u003E\u003Ccode\u003E6d89f9a\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003EDatabase\u003C\u002Fstrong\u003E: Add float cast that supports comma \u003Cem\u003E(commit by @h4kuna)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.52",date:"2023-06-01T09:44:42Z",body:"\u003Ch3 id=\"bug-bug-fixes\"\u003E:bug: Bug Fixes\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F4292a8a578a0a77aa72d608a46aed977c53b0418\"\u003E\u003Ccode\u003E4292a8a\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003ERules\u003C\u002Fstrong\u003E: Improve NumberRule range of supported int\u002Ffloat values \u003Cem\u003E(commit by @h4kuna)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.51",date:"2023-05-25T12:52:07Z",body:"\u003Ch3 id=\"bug-bug-fixes\"\u003E:bug: Bug Fixes\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002Fa54eeb49248d41794fd943a127d5d518cb544d41\"\u003E\u003Ccode\u003Ea54eeb4\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003EQueue\u003C\u002Fstrong\u003E: Correctly ensure that queue is not overridden when using property \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"},{name:"v0.0.50",date:"2023-05-25T11:19:38Z",body:"\u003Ch3 id=\"bug-bug-fixes\"\u003E:bug: Bug Fixes\u003C\u002Fh3\u003E\n\u003Cul\u003E\n\u003Cli\u003E\u003Ca target=\"_blank\" href=\"https:\u002F\u002Fgithub.com\u002Fwrk-flow\u002Flarastrict\u002Fcommit\u002F4844918256ff68f7a4c68d93fdef894d080cdc85\"\u003E\u003Ccode\u003E4844918\u003C\u002Fcode\u003E\u003C\u002Fa\u003E - \u003Cstrong\u003EQueue\u003C\u002Fstrong\u003E: Ensure that queue is not overridden when using property \u003Cem\u003E(commit by @pionl)\u003C\u002Fem\u003E\u003C\u002Fli\u003E\n\u003C\u002Ful\u003E\n"}],settings:{title:"LaraStrict",url:"https:\u002F\u002Flarastrict.com",defaultDir:"docs",defaultBranch:"main",filled:c,github:"wrk-flow\u002Flarastrict",twitter:"pionl",category:a},menu:{open:h},i18n:{routeParams:{}}},serverRendered:c,routePath:g,config:{_app:{basePath:f,assetsPath:"\u002F_nuxt\u002F",cdnURL:d},content:{dbHash:"63e36837"}},__i18n:{langs:{}},colorMode:{preference:i,value:i,unknown:c,forced:h}}}("","Database",true,null,"index","\u002F","\u002Fdatabase\u002Fevents",false,"system"));