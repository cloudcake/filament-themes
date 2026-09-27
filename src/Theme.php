<?php

namespace Cloudcake\Themes;

use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Assets\Css;
use Cloudcake\Themes\Concerns\Plugin as PluginConcerns;

class Theme implements Plugin
{
    use
        PluginConcerns\ConfiguresAuthTheme,
        PluginConcerns\ConfiguresBorders,
        PluginConcerns\ConfiguresColours,
        PluginConcerns\ConfiguresNotifications,
        PluginConcerns\ConfiguresHeadings,
        PluginConcerns\ConfiguresLightMode,
        PluginConcerns\ConfiguresPreset,
        PluginConcerns\ConfiguresShadows,
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
        $panel->assets([
            Css::make('cloudcake-themes-prestine', __DIR__ . '/../resources/dist/css/index.css')
        ]);

        $this
            ->applyPreset($panel)
            ->applyAuthTheme($panel)
            ->applyBorders($panel)
            ->applyColours($panel)
            ->applyTransitions($panel)
            ->applyHeadings($panel)
            ->applyLightMode($panel)
            ->applyNotifications($panel)
            ->applyShadows($panel);
    }

    public function boot(Panel $panel): void
    {
        // Implemented, not used.
    }
}