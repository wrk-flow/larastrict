<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Unit\Testing\Concerns;

use Illuminate\Foundation\Http\FormRequest;

class TestContainerRequest extends FormRequest
{
    final public const KeyTest = 'test';

    public function rules(): array
    {
        return [
            self::KeyTest => ['required'],
        ];
    }

    protected function passedValidation()
    {
        $autoAction = $this->container->make(AutoAction::class, ['test']);
        assert($autoAction instanceof AutoAction);

        $customAction = $this->container->make(CustomAction::class);
        assert($customAction instanceof CustomAction);

        $customAction->autoAction = $autoAction;
    }
}
