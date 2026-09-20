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
    protected bool|Closure $countUpWidgets = true;
    protected array|false|Closure $blooming = [];

    protected null|array|string|Closure $primaryColour = null;
    protected null|array|string|Closure $darkPanelColour = null;
    protected null|array|string|Closure $lightPanelColour = null;

    /**
     * Make an instance of the plugin.
     *
     * @return static
     */
    public static function make(
        Roundness|Closure              $roundness = Roundness::Moderate,
        Shadows|Closure                $shadows = Shadows::Dramatic,
        array|false|Closure            $blooming = [],
        bool|Closure                   $headingIcons = false,
        bool|Closure                   $forceLightMode = false,
        bool|Closure                   $forceDarkMode = false,
        array|bool|null|string|Closure $primaryColour = null,
        array|bool|null|string|Closure $darkPanelTint = null,
        array|bool|null|string|Closure $lightPanelTint = null,
    ): static
    {
        $instance = app(static::class);
        $instance->roundness($roundness);
        $instance->shadows($shadows);
        $instance->headingIcons($headingIcons);
        $instance->forceLightMode($forceLightMode);
        $instance->forceDarkMode($forceDarkMode);
        $instance->primaryColour($primaryColour);
        $instance->darkPanelTint($darkPanelTint);
        $instance->lightPanelTint($lightPanelTint);
        $instance->blooming(!blank($blooming) ? $blooming : [
            new Bloom(position: BloomPosition::UpperCenter, spreadX: 100, spreadY: 45),
            new Bloom(position: BloomPosition::BottomLeft, spreadX: 15, spreadY: 85),
            new Bloom(position: BloomPosition::BottomRight, spreadX: 50, spreadY: 30),
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

    public function primaryColour(array|string|null|Closure $colour): static
    {
        $this->primaryColour = $colour;

        return $this;
    }

    public function darkPanelTint(array|string|null|Closure $colour): static
    {
        $this->darkPanelColour = $colour;

        return $this;
    }

    public function lightPanelTint(array|string|null|Closure $colour): static
    {
        $this->lightPanelColour = $colour;

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
                    'darkPanelColour' => $this->getColourFromInput($panel->evaluate($this->darkPanelColour)),
                    'lightPanelColour' => $this->getColourFromInput($panel->evaluate($this->lightPanelColour)),
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
            ->when(
                $primaryColour = $panel->evaluate($this->primaryColour),
                fn($panel) => $panel->colors(['primary' => $this->getColourFromInput($primaryColour)]),
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