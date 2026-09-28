<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Cloudcake\Themes\Enums\Preset;
use Filament\Panel;

trait ConfiguresPreset
{
    protected Preset|Closure|null $preset = Preset::Default;

    public function preset(Preset|Closure|null $preset): static
    {
        $this->preset = $preset;

        return $this;
    }

    protected function applyPreset(Panel $panel): static
    {
        $panel->when(
            fn($panel) => $panel->evaluate($this->preset) !== null,
            fn($panel) => $panel->evaluate($this->preset)->apply($this, $panel)
        );

        return $this;
    }
}