<?php declare(strict_types=1);

namespace LaraStrict\Testing\Contracts;

interface FindAllClassesActionContract
{
	/**
	 * @return array<class-string>
	 */
	public function execute(): array;
}
