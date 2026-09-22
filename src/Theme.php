<?php

/** @noinspection PhpReturnValueOfMethodIsNeverUsedInspection */

namespace Cloudcake\Themes;

use Closure;
use Filament\Support\Assets\Css;
use Filament\Contracts\Plugin;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;

class Theme implements Plugin
{
    protected Roundness $roundness = Roundness::Moderate;
    protected Shadows $shadows = Shadows::Dramatic;

    protected bool|Closure $headingIcons = false;
    protected bool|Closure $forceLightMode = false;
    protected bool|Closure $forceDarkMode = false;
    protected bool|Closure $pageTransitions = true;
    protected bool|Closure $rails = true;

    protected float|Closure $pageTransitionDuration = 0;
    protected float|Closure $pageTransitionOffset = 0;

    protected array|false|Closure $blooming = [];

    protected null|array|string|Closure $darkPrimaryColour = null;
    protected null|array|string|Closure $lightPrimaryColour = null;
    protected null|array|string|Closure $darkBackgroundColour = null;
    protected bool|Closure $darkBackgroundColourShaded = true;
    protected null|array|string|Closure $lightBackgroundColour = null;
    protected bool|Closure $lightBackgroundColourShaded = true;

    /**
     * Make an instance of the plugin.
     *
     * @return static
     */
    public static function make(): static
    {
        $instance = app(static::class);
        $instance->roundness(Roundness::Moderate);
        $instance->shadows(Shadows::Strong);
        $instance->headingIcons();
        $instance->forceLightMode(false);
        $instance->forceDarkMode(false);
        $instance->primaryColour(Color::Indigo, Color::Indigo);
        $instance->background(
            dark: '#11111a',
            light: '#F1F5F8',
            darkShaded: true,
            lightShaded: true
        );
        $instance->transitions(
            condition: true,
            duration: 0.5,
            offset: 1.5
        );
        $instance->rails();
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

    public function primaryColour(array|string|null|Closure $dark, array|string|null|Closure $light): static
    {
        $this->darkPrimaryColour = $dark;
        $this->lightPrimaryColour = $light;

        return $this;
    }

    public function background(array|string|null|Closure $dark, array|string|null|Closure $light, bool $darkShaded = false, bool $lightShaded = false): static
    {
        $this->darkBackgroundColour = $dark;
        $this->lightBackgroundColour = $light;
        $this->darkBackgroundColourShaded = $darkShaded;
        $this->lightBackgroundColourShaded = $lightShaded;

        return $this;
    }

    private function registerTheme(Panel $panel): static
    {
        $panel
            ->assets([
                Css::make('cloudcake-themes-prestine', __DIR__ . '/../resources/dist/css/index.css')
            ])
            ->when(
                fn($panel) => $panel->evaluate($this->headingIcons) === true,
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
                    'darkBackgroundColourShaded' => $panel->evaluate($this->darkBackgroundColourShaded),
                    'lightPrimaryColour' => $this->getColourFromInput($panel->evaluate($this->lightPrimaryColour)),
                    'lightBackgroundColour' => $panel->evaluate($this->lightBackgroundColour),
                    'lightBackgroundColourShaded' => $panel->evaluate($this->lightBackgroundColourShaded),
                    'pageTransitions' => $panel->evaluate($this->pageTransitions),
                    'pageTransitionDuration' => $panel->evaluate($this->pageTransitionDuration),
                    'pageTransitionOffset' => $panel->evaluate($this->pageTransitionOffset),
                    'rails' => $panel->evaluate($this->rails),
                ])
            )
            ->when(
                fn($panel) => $panel->evaluate($this->forceDarkMode),
                fn($panel) => $panel->darkMode(isForced: true)
            )
            ->when(
                $panel->evaluate($this->forceLightMode),
                fn($panel) => $panel->darkMode(condition: false, isForced: true)
            )
//            ->when(
//                $primaryColour = $panel->evaluate($this->darkPrimaryColour),
//                fn($panel) => $panel->colors(['primary' => $this->getColourFromInput($primaryColour)]),
//            )
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