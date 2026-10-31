<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Filament\Forms\Components\Select;
use Filament\Panel;

trait ConfiguresComponents
{
    protected function applyComponents(Panel $panel): static
    {
        Select::configureUsing(fn(Select $component) => $component
            ->searchable()
        );

        return $this;
    }
}
