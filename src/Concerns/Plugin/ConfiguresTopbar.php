<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

trait ConfiguresTopbar
{
    protected string|null|HtmlString|Closure $toolbarAdvertisement = null;

    public function toolbarAdvertisement(string|null|HtmlString|Closure $content): static
    {
        $this->toolbarAdvertisement = $content;

        return $this;
    }

    protected function applyTopbar(Panel $panel): static
    {
        $panel
            ->themeSwitcher(fn() => $panel->hasTopbar())
            ->topbar(false)
            ->when(
                fn($panel) => $panel->hasTopNavigation(),
                fn($panel) => $panel->topbar()->sidebarCollapsibleOnDesktop(false)->sidebarFullyCollapsibleOnDesktop(false),
                fn($panel) => $panel->renderHook(PanelsRenderHook::CONTENT_BEFORE, fn() => view('cloudcake-themes::hooks.custom-topbar', [
                    'databaseNotificationsEnabled' => $panel->hasDatabaseNotifications(),
                    'advertisement' => $panel->evaluate($this->toolbarAdvertisement),
                    'panel' => $panel
                ]))
            );

        return $this;
    }
}