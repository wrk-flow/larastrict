<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Commands\MakeExpectationCommand;

interface MultiFunctionContract
{
    public function self(string $first, int $second, bool $third): self;

    /**
     * @return $this
     */
    public function phpDocThis(string $first, int $second, bool $third);

    /**
     * @param string $first
     * @param int    $second
     * @param bool   $second
     *
     * @return $this
     */
    public function phpDocThisParams($first, $second, $third);


    /**
     * @return bool
     */
    public function phpDocBool($first, $second, callable $third);

    /**
     * @return string
     */
    public function phpDocString($first, $second, $third);

    /**
     * @return float
     */
    public function phpDocFloat($first, $second, $third);

    /**
     * @return mixed
     */
    public function phpDocMixed($first, $second, $third);

    /**
     * @return static
     */
    public function phpDocStatic($first, $second, $third);

    /**
     * @return MultiFunctionContract
     */
    public function selfViaClass($first, $second, $third);

    public function noReturn($first, $second, $third);

    public function mixed($first, $second, $third): mixed;

    public function noParams(): string;
}
