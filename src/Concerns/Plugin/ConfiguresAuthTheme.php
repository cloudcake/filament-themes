<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Cloudcake\Themes\Enums\AuthLayout;
use Filament\Panel;
use Filament\View\PanelsRenderHook;

trait ConfiguresAuthTheme
{
    protected AuthLayout|Closure $authLayout = AuthLayout::Default;

    protected string|null|Closure $authTagline = "To modify your application's authentication tagline, add the 'tagline' property to the ->auth() call when configuring the plugin.";

    public function auth(AuthLayout|Closure $layout, string|null|Closure $tagline = null): static
    {
        $this->authLayout = $layout;
        $this->authTagline = $tagline;

        return $this;
    }

    protected function applyAuthTheme(Panel $panel): static
    {
        $panel->when(
            fn($panel) => $panel->evaluate($this->authLayout) !== AuthLayout::Default,
            fn($panel) => $panel->renderHook(
                PanelsRenderHook::SIMPLE_LAYOUT_START,
                fn() => view('cloudcake-themes::layouts.auth', [
                    'layout' => $panel->evaluate($this->authLayout),
                    'tagline' => $panel->evaluate($this->authTagline),
                ]),
            )
        );

        return $this;
    }
}