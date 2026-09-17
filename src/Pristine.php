<?php

/** @noinspection PhpReturnValueOfMethodIsNeverUsedInspection */

namespace Cloudcake\Themes;

use Filament\Support\Assets\Css;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Facades\FilamentView;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;

class Pristine implements Plugin
{
    /**
     * Make an instance of the plugin.
     *
     * @return static
     */
    public static function make(): static
    {
        return app(static::class);
    }

    /**
     * Unique plugin identifier.
     *
     * @return string
     */
    public function getId(): string
    {
        return 'cloudcake-theme-prestine';
    }

    /**
     * Plugin registration.
     *
     * @param Panel $panel
     * @return void
     */
    public function register(Panel $panel): void
    {
        $this
            ->registerTheme($panel)
            ->registerAssets($panel);
    }

    public function boot(Panel $panel): void
    {
        FilamentView::registerRenderHook(
            PanelsRenderHook::PAGE_HEADER_HEADING_BEFORE,
            fn (): string => Blade::render(<<<'BLADE'
                @php
                $icon = $this::getNavigationIcon() ?? false;
                @endphp
                 @if ($icon)
                <span class="inline-flex items-center align-top ml-1 mr-2">
                    <x-filament::icon
                        :icon="$icon"
                        class="h-8 w-8 text-gray-500 dark:text-gray-700"
                    />
                </span>
                @endif
           
        BLADE),
        );
    }

    private function registerTheme(Panel $panel): static
    {
        $panel->userMenuItems([
            'profile' => fn($action) => $action
                ->icon('tabler-user-key')
                ->visible(fn() => auth()->check())
                ->label(fn() => auth()->user()->name ?? null),
        ]);

        return $this;
    }

    private function registerAssets(Panel $panel): void
    {
        $panel->assets([Css::make('cloudcake-themes-prestine', __DIR__ . '/../resources/dist/css/index.css')]);
    }
}