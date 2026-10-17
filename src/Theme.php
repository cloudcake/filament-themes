<?php

namespace Cloudcake\Themes;

use Cloudcake\Themes\Enums\Preset;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Assets\Css;
use Cloudcake\Themes\Concerns\Plugin as PluginConcerns;

class Theme implements Plugin
{
    public const ASSET_ID = 'cloudcake-themes';

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
        // The stylesheet already includes Filament's theme.css, so it replaces the default theme instead
        // of loading before it. A panel with its own viteTheme keeps it, and gets ours as an extra stylesheet.
        if (blank($panel->getViteTheme())) {
            $panel->theme(self::ASSET_ID);
        } else {
            $panel->assets([
                Css::make('cloudcake-themes-styles', __DIR__ . '/../resources/dist/css/index.css'),
            ]);
        }

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