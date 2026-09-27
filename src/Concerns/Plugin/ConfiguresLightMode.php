<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Cloudcake\Themes\Enums\AuthLayout;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

trait ConfiguresLightMode
{
    protected bool|Closure $forceLightMode = false;
    protected bool|Closure $forceDarkMode = false;

    public function forceDarkMode(bool|Closure $condition = true): static
    {
        $this->forceDarkMode = $condition;

        return $this;
    }

    public function forceLightMode(bool|Closure $condition = true): static
    {
        $this->forceLightMode = $condition;

        return $this;
    }

    private function applyLightMode(Panel $panel): static
    {
        $panel
            ->when(
                fn($panel) => $panel->evaluate($this->forceDarkMode),
                fn($panel) => $panel->darkMode(isForced: true)
            )
            ->renderHook(
                name: PanelsRenderHook::SIMPLE_LAYOUT_END,
                hook: fn() => view('cloudcake-themes::hooks.light-switch')
            );

        return $this;
    }
}