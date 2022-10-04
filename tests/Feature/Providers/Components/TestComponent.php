<?php

declare(strict_types=1);

namespace Tests\LaraStrict\Feature\Providers\Components;

use Illuminate\View\Component;

class TestComponent extends Component
{
    public function render(): string
    {
        return 'and class component';
    }
}
