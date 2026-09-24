<?php

/** @noinspection PhpReturnValueOfMethodIsNeverUsedInspection */

namespace Cloudcake\Themes;

use Closure;
use Filament\Support\Assets\Css;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

class Theme implements Plugin
{
    protected Roundness $roundness = Roundness::Pill;
    protected Shadows $shadows = Shadows::Moderate;

    protected bool|Closure $headingIcons = true;
    protected bool|Closure $forceLightMode = false;
    protected bool|Closure $forceDarkMode = false;
    protected bool|Closure $pageTransitions = true;
    protected bool|Closure $rails = true;

    protected float|Closure $pageTransitionDuration = 0;
    protected float|Closure $pageTransitionOffset = 0;

    protected array|false|Closure $blooming = [];

    protected null|array|string|Closure $darkPrimaryColour = Color::Indigo;
    protected null|array|string|Closure $lightPrimaryColour = Color::Indigo;
    protected null|array|string|Closure $darkBackgroundColour = '#11111a';
    protected null|array|string|Closure $darkBackgroundTintColour = '#6D8196';
    protected null|array|string|Closure $lightBackgroundColour = '#F1F5F8';
    protected null|array|string|Closure $lightBackgroundTintColour = 'skyblue';

    /**
     * Make an instance of the plugin.
     *
     * @return static
     */
    public static function make(): static
    {
        $instance = app(static::class);
        $instance->roundness($instance->roundness);
        $instance->shadows($instance->shadows);
        $instance->headingIcons($instance->headingIcons);
        $instance->forceLightMode(false);
        $instance->forceDarkMode(false);
        $instance->primaryColour(fn(Panel $panel) => $panel->getColors()['primary'] ?? $instance->darkPrimaryColour);
        $instance->background(
            dark: $instance->darkBackgroundColour,
            light: $instance->lightBackgroundColour,
            darkTint: $instance->darkBackgroundTintColour,
            lightTint: $instance->lightBackgroundTintColour
        );
        $instance->transitions(
            condition: $instance->pageTransitions,
            duration: $instance->pageTransitionDuration,
            offset: $instance->pageTransitionOffset
        );
        $instance->rails($instance->rails);
        $instance->blooming([
            new Bloom(
                position: BloomPosition::UpperCenter,
                spreadX: 100,
                spreadY: 30,
                darkIntensity: 10,
                darkColour: 'var(--primary-900)',
                lightColour: 'var(--primary-500)',
                lightIntensity: 20,
            ),

            new Bloom(
                position: BloomPosition::BottomLeft,
                spreadX: 20,
                spreadY: 40,
                darkIntensity: 8,
                darkColour: 'var(--primary-900)',
                lightColour: 'var(--primary-600)',
                lightIntensity: 20,
            ),

            new Bloom(
                position: BloomPosition::BottomRight,
                spreadX: 40,
                spreadY: 30,
                darkIntensity: 15,
                darkColour: 'var(--primary-700)',
                lightColour: 'var(--primary-600)',
                lightIntensity: 20,
            ),
        ]);

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
        $this->registerTheme($panel);
    }

    public function boot(Panel $panel): void
    {
    }

    public function roundness(Closure|Roundness $roundness): static
    {
        $this->roundness = $roundness;

        return $this;
    }

    public function shadows(Closure|Shadows $shadows): static
    {
        $this->shadows = $shadows;

        return $this;
    }

    public function blooming(Closure|array|false $blooming): static
    {
        $this->blooming = $blooming;

        return $this;
    }

    public function headingIcons(bool|Closure $condition = true): static
    {
        $this->headingIcons = $condition;

        return $this;
    }

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

    public function transitions(bool|Closure $condition = true, float|Closure $duration = 0.5, float|Closure $offset = 1.5): static
    {
        $this->pageTransitions = $condition;
        $this->pageTransitionDuration = $duration;
        $this->pageTransitionOffset = $offset;

        return $this;
    }

    public function rails(bool|Closure $condition = true): static
    {
        $this->rails = $condition;

        return $this;
    }

    public function primaryColour(array|string|null|Closure $dark, array|string|null|Closure $light = null): static
    {
        $this->darkPrimaryColour = $dark;
        $this->lightPrimaryColour = $light ?? $dark;

        return $this;
    }

    public function background(
        array|string|null|Closure $dark,
        array|string|null|Closure $light,
        array|string|null|Closure $darkTint = null,
        array|string|null|Closure $lightTint = null
    ): static
    {
        $this->darkBackgroundColour = $dark;
        $this->lightBackgroundColour = $light;
        $this->darkBackgroundTintColour = $darkTint;
        $this->lightBackgroundTintColour = $lightTint;

        return $this;
    }

    private function registerTheme(Panel $panel): static
    {
        $panel
            ->assets([
                Css::make('cloudcake-themes-prestine', __DIR__ . '/../resources/dist/css/index.css')
            ])
            ->when(
                fn($panel) => $panel->evaluate($this->headingIcons),
                fn($panel) => $panel->renderHook(
                    PanelsRenderHook::PAGE_HEADER_HEADING_BEFORE,
                    fn() => view('cloudcake-themes::hooks.heading-icon')
                ),
            )
            ->renderHook(
                PanelsRenderHook::STYLES_AFTER,
                fn() => view('cloudcake-themes::hooks.styles', [
                    'roundness' => $panel->evaluate($this->roundness),
                    'shadows' => $panel->evaluate($this->shadows),
                    'blooming' => $panel->evaluate($this->blooming),
                    'darkPrimaryColour' => $this->getColourFromInput($panel->evaluate($this->darkPrimaryColour)),
                    'darkBackgroundColour' => $panel->evaluate($this->darkBackgroundColour),
                    'darkBackgroundShadeColour' => $panel->evaluate($this->darkBackgroundTintColour),
                    'lightPrimaryColour' => $this->getColourFromInput($panel->evaluate($this->lightPrimaryColour)),
                    'lightBackgroundColour' => $panel->evaluate($this->lightBackgroundColour),
                    'lightBackgroundShadeColour' => $panel->evaluate($this->lightBackgroundTintColour),
                    'pageTransitions' => $panel->evaluate($this->pageTransitions),
                    'pageTransitionDuration' => $panel->evaluate($this->pageTransitionDuration),
                    'pageTransitionOffset' => $panel->evaluate($this->pageTransitionOffset),
                ])
            )
            ->when(
                fn($panel) => $panel->evaluate($this->rails),
                fn($panel) => $panel->renderHook(
                    PanelsRenderHook::BODY_START,
                    fn () => new HtmlString(
                        '<script>
                            document.body.classList.add("rails");
                        </script>'
                    ),
                )
            )
            ->renderHook(
                PanelsRenderHook::SIMPLE_LAYOUT_START,
                fn() => view('cloudcake-themes::layouts.auth', [
                    'layout' => AuthLayout::Editorial,
                    'tagline' => "To modify your application's authentication tagline, add the 'tagline' key to the ->auth() call when configuring the plugin."
                ]),
            )
            ->when(
                fn($panel) => $panel->evaluate($this->forceDarkMode),
                fn($panel) => $panel->darkMode(isForced: true)
            )
            ->when(
                $panel->evaluate($this->forceLightMode),
                fn($panel) => $panel->darkMode(condition: false, isForced: true)
            )
            ->userMenuItems([
                'profile' => fn($action) => $action
                    ->icon('tabler-user-key')
                    ->visible(fn() => auth()->check())
                    ->label(fn() => auth()->user()->name ?? null),
            ]);

        return $this;
    }

    private function getColourFromInput(mixed $input): array|null
    {
        $color = null;

        if (is_array($input))
            $color = $input;
        elseif (is_string($input)) {
            $color = trim($input);

            if (str_starts_with($color, '#'))
                $color = Color::hex($color);
            elseif (preg_match('/^rgba?\(\s*[^)]+\)$/i', $color))
                $color = Color::rgb($color);
            elseif (preg_match('/^rgba?\(\s*[^)]+\)$/i', $color))
                $color = Color::rgb($color);
            elseif (preg_match('/^oklch\(\s*[^)]+\)$/i', $color))
                $color = Color::hex(Color::convertToHex($color));
            else
                $color = Color::hex('#' . $color);
        }

        return $color;
    }
}