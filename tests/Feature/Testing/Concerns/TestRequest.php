<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Testing\Concerns;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest
{
    final public const string KeyTest = 'test';

    /**
     * @return array<array-key, mixed>
     */
    public function rules(): array
    {
        return [
            self::KeyTest => ['required'],
        ];
    }
}
