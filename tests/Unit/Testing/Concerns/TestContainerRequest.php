<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\Concerns;

use Illuminate\Foundation\Http\FormRequest;

class TestContainerRequest extends FormRequest
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

    protected function passedValidation()
    {
        $autoAction = $this->container->make(AutoAction::class, ['test']);
        // TestingContainer can be configured with an invalid binding at runtime.
        // @phpstan-ignore-next-line
        assert($autoAction instanceof AutoAction);

        $customAction = $this->container->make(CustomAction::class);
        // @phpstan-ignore-next-line
        assert($customAction instanceof CustomAction);

        $customAction->autoAction = $autoAction;
    }
}
