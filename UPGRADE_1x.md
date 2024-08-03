# Upgrade to 1.x version

Due to the test bench package we have dropped Laravel 9 and PHPUnit 9.

You need to upgrade your test cases to the new version. Data providers are now static methods.

You can use [rector](https://getrector.com/blog/how-to-upgrade-to-phpunit-10-in-diffs) with additional manual changes
like this:

- replace `protected function generateData(): array` with `protected static function generateData(): arrayt`
- replace `public function data(): array` with `public static function data(): array`

Please check the code changes for detailed information.
