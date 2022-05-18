<?php

declare(strict_types=1);

namespace LaraStrict\View\Components;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Blade;
use Illuminate\View\Component as LaravelComponent;

abstract class Component extends LaravelComponent implements Responsable
{
    public function toResponse($request)
    {
        return new Response(Blade::renderComponent($this), 200, [
            'Content-Type' => 'text/html',
        ]);
    }
}
