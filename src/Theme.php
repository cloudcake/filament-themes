<?php

namespace Cloudcake\Themes;

use Cloudcake\Themes\Enums\Preset;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Assets\Css;
use Cloudcake\Themes\Concerns\Plugin as PluginConcerns;
use Filament\Support\Assets\Js;

class Theme implements Plugin
{
    use
        PluginConcerns\ConfiguresAnimations,
        PluginConcerns\ConfiguresAuthTheme,
        PluginConcerns\ConfiguresBackgrounds,
        PluginConcerns\ConfiguresBlooming,
        PluginConcerns\ConfiguresBorders,
        PluginConcerns\ConfiguresColours,
        PluginConcerns\ConfiguresFont,
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
     * @param Preset|null $preset
     * @return static
     */
    public static function make(Preset|null $preset = null): static
    {
        $instance = app(static::class);
        $preset?->apply($instance);

        return $instance;
    }

    public function getId(): string
    {
        return 'cloudcake-themes';
    }

    public function register(Panel $panel): void
    {
        $panel->assets([
            Css::make('cloudcake-themes-styles', __DIR__ . '/../resources/dist/css/index.css'),
            // Js::make('tailwind-jit-cdn', 'https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4'),
        ]);

        $this
            ->applyAnimations($panel)
            ->applyNotifications($panel)
            ->applyAuthTheme($panel)
            ->applyBackgrounds($panel)
            ->applyBorders($panel)
            ->applyBlooming($panel)
            ->applyColours($panel)
            ->applyFont($panel)
            ->applyTransitions($panel)
            ->applyHeadings($panel)
            ->applyLightMode($panel)
            ->applyShadows($panel)
            ->applyTopbar($panel);
    }

    public function boot(Panel $panel): void
    {
    }
}