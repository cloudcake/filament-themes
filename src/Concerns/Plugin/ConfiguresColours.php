<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Cloudcake\Themes\Enums\BloomPosition;
use Cloudcake\Themes\Settings\Bloom;
use Cloudcake\Themes\Settings\Styles;
use Filament\Panel;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

trait ConfiguresColours
{
    protected null|array|string|Closure $darkPrimaryColour = Color::Indigo;
    protected null|array|string|Closure $lightPrimaryColour = Color::Indigo;
    protected null|array|string|Closure $darkBackgroundColour = '#11111a';
    protected null|array|string|Closure $darkBackgroundTintColour = '#6D8196';
    protected null|array|string|Closure $lightBackgroundColour = '#F1F5F8';
    protected null|array|string|Closure $lightBackgroundTintColour = 'skyblue';
    protected array|false|Closure $blooming = false;

    public function primaryColour(array|string|null|Closure $dark, array|string|null|Closure $light = null): static
    {
        $this->darkPrimaryColour = $dark;
        $this->lightPrimaryColour = $light ?? $dark;

        return $this;
    }

    public function background(
        array|string|null|Closure $dark,
        array|string|null|Closure $light
    ): static
    {
        $this->darkBackgroundColour = $dark;
        $this->lightBackgroundColour = $light;

        return $this;
    }

    public function tint(
        array|string|null|Closure $dark = null,
        array|string|null|Closure $light = null
    ): static
    {
        $this->darkBackgroundTintColour = $dark;
        $this->lightBackgroundTintColour = $light;

        return $this;
    }

    public function blooming(Closure|array|bool $blooming = true): static
    {
        $this->blooming = $blooming;

        return $this;
    }

    protected function applyColours(Panel $panel): static
    {
        $panel->renderHook(
            PanelsRenderHook::STYLES_AFTER,
            function () use ($panel) {
                $blooming = $panel->evaluate($this->blooming);

                if ($blooming !== false && is_array($blooming) && blank($blooming))
                {
                    $blooming = [
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
                    ];
                }

                if ($blooming !== false) {
                    $lightBloomTokens = Styles::bloomTokens($blooming, dark: false);
                    $darkBloomTokens = Styles::bloomTokens($blooming, dark: true);
                } else {
                    $lightBloomTokens = '';
                    $darkBloomTokens = '';
                }

                $lightPrimaryColour = $this->getColourFromInput($panel->evaluate($this->lightPrimaryColour));
                $lightBackgroundColour = $panel->evaluate($this->lightBackgroundColour);
                $lightTintingColour = $panel->evaluate($this->lightBackgroundTintColour);

                $lightShadeTokens = Styles::shadeTokens($lightPrimaryColour, 'primary');
                $lightBackgroundTokens = Styles::backgroundTokens($lightBackgroundColour, $lightTintingColour);

                $darkPrimaryColour = $this->getColourFromInput($panel->evaluate($this->darkPrimaryColour));
                $darkBackgroundColour = $panel->evaluate($this->darkBackgroundColour);
                $darkTintingColour = $panel->evaluate($this->darkBackgroundTintColour);

                $darkShadeTokens = Styles::shadeTokens($darkPrimaryColour, 'primary');
                $darkBackgroundTokens = Styles::backgroundTokens($darkBackgroundColour, $darkTintingColour);

                return new HtmlString(
                    <<<HTML
                    <style>                    
                        body {
                            $lightBloomTokens
                            $lightShadeTokens
                            $lightBackgroundTokens
                        }
                    
                        .dark body {
                            $darkBloomTokens
                            $darkShadeTokens
                            $darkBackgroundTokens
                        }
                    </style>
                HTML
                );
            }
        );

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