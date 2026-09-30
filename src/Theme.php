<?php

namespace Cloudcake\Themes;

use Filament\Contracts\Plugin;
use Filament\Enums\GlobalSearchPosition;
use Filament\Livewire\GlobalSearch;
use Filament\Panel;
use Filament\Support\Assets\Css;
use Cloudcake\Themes\Concerns\Plugin as PluginConcerns;

class Theme implements Plugin
{
    use
        PluginConcerns\ConfiguresAuthTheme,
        PluginConcerns\ConfiguresBackgrounds,
        PluginConcerns\ConfiguresBlooming,
        PluginConcerns\ConfiguresBorders,
        PluginConcerns\ConfiguresColours,
        PluginConcerns\ConfiguresNotifications,
        PluginConcerns\ConfiguresHeadings,
        PluginConcerns\ConfiguresLightMode,
        PluginConcerns\ConfiguresPreset,
        PluginConcerns\ConfiguresShadows,
        PluginConcerns\ConfiguresTopbar,
        PluginConcerns\ConfiguresTransitions;

    /**
     * Make an instance of the plugin.
     *
     * @return static
     */
    public static function make(): static
    {
        return app(static::class);
    }

    public function getId(): string
    {
        return 'cloudcake-themes';
    }

    public function register(Panel $panel): void
    {
        $panel
            ->sidebarCollapsibleOnDesktop()
            ->topbar(false)
            ->font('Inter Tight')
            ->assets([
                Css::make('cloudcake-themes-prestine', __DIR__ . '/../resources/dist/css/index.css')
            ]);

        $this
            ->applyPreset($panel)
            ->applyAuthTheme($panel)
            ->applyBackgrounds($panel)
            ->applyBorders($panel)
            ->applyBlooming($panel)
            ->applyColours($panel)
            ->applyTransitions($panel)
            ->applyHeadings($panel)
            ->applyLightMode($panel)
            ->applyShadows($panel)
            ->applyNotifications($panel)
            ->applyTopbar($panel);

    }

    public function boot(Panel $panel): void
    {
        $panel
            ->when(
                fn($panel) => $panel->hasTopNavigation(),
                fn($panel) => $panel->sidebarCollapsibleOnDesktop(false)->sidebarFullyCollapsibleOnDesktop(false)
            )
            ->globalSearch(position: GlobalSearchPosition::Topbar)
            ->themeSwitcher(fn() => $panel->hasTopbar());
    }
}