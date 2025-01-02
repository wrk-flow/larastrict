<?php declare(strict_types=1);

namespace LaraStrict\Testing\Contracts;

interface GetBasePathForAssertsActionContract
{
	public function execute(): string;
}
