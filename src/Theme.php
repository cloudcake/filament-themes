<?php

/** @noinspection PhpReturnValueOfMethodIsNeverUsedInspection */

namespace Cloudcake\Themes;

use Closure;
use Filament\Support\Assets\Css;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\View\PanelsRenderHook;

class Theme implements Plugin
{
    protected bool|Closure $headingIcons = false;

    protected Roundness $roundness = Roundness::Moderate;

    /**
     * Make an instance of the plugin.
     *
     * @return static
     */
    public static function make(
        Roundness|Closure $roundness = Roundness::Moderate,
        bool|Closure $headingIcons = false,
    ): static
    {
        $instance = app(static::class);
        $instance->roundness($roundness);
        $instance->headingIcons($headingIcons);

        return $instance;
    }

    /**
     * Unique plugin identifier.
     *
     * @return string
     */
    public function getId(): string
    {
        return 'cloudcake-themes';
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
            ->registerAssets($panel)
        ->registerHooks($panel);
    }

    public function boot(Panel $panel): void
    {

    }

    public function roundness(Closure|Roundness $roundness): static
    {
        $this->roundness = $roundness;

        return $this;
    }

    public function headingIcons(Closure|bool $condition = true) : static
    {
        $this->headingIcons = $condition;

        return $this;
    }

    private function registerHooks(Panel $panel) : static
    {
        $panel->when(
            $panel->evaluate($this->headingIcons) === true,
            fn($panel) => $panel->renderHook(
                PanelsRenderHook::PAGE_HEADER_HEADING_BEFORE,
                fn () => view('cloudcake-themes::hooks.heading-icon')
            ),
        );

        $panel->renderHook(
            PanelsRenderHook::STYLES_AFTER,
            fn() => view('cloudcake-themes::hooks.styles', [
                'roundness' => $panel->evaluate($this->roundness)
            ])
        );

        return $this;
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

    private function registerAssets(Panel $panel): static
    {
        $panel->assets([
            Css::make('cloudcake-themes-prestine', __DIR__ . '/../resources/dist/css/index.css')
        ]);

        return $this;
    }
}