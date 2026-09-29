<?php

namespace Cloudcake\Themes\Enums;

use Cloudcake\Themes\Settings\Bloom;
use Cloudcake\Themes\Theme;
use Filament\Panel;
use Filament\Support\Colors\Color;

enum Preset
{
    case Default;
    case AddPay;
    case Pristine;

    public function apply(Theme $theme, Panel $panel): void
    {
        $callback = match ($this) {
            self::Default => function (Theme $theme, Panel $panel) {
                $theme
                    ->transitions(condition: false)
                    ->blooming([])
                    ->shadows(shadows: Shadows::Default)
                    ->borders(style: BorderStyle::Default)
                    ->roundness(Roundness::Default)
                    ->headings(icon: false, underline: false);
            },

            self::AddPay => function (Theme $theme, Panel $panel) {
                $theme
                    ->auth(AuthLayout::Editorial, tagline: 'The best company in the land!')
                    ->shadows(Shadows::Default)
                    ->borders(style: BorderStyle::Solid, width: 1)
                    ->roundness(Roundness::Slight)
                    ->blooming([
                        new Bloom(
                            position: BloomPosition::UpperLeft,
                            spreadX: 20,
                            spreadY: 70,
                            darkIntensity: 11,
                            darkColour: 'var(--primary-900)',
                            lightColour: 'var(--primary-500)',
                            lightIntensity: 20,
                        ),

                        new Bloom(
                            position: BloomPosition::UpperCenter,
                            spreadX: 80,
                            spreadY: 30,
                            darkIntensity: 20,
                            darkColour: 'var(--primary-900)',
                            lightColour: 'var(--primary-400)',
                            lightIntensity: 20,
                        ),

                        new Bloom(
                            position: BloomPosition::BottomLeft,
                            spreadX: 70,
                            spreadY: 40,
                            darkIntensity: 11,
                            darkColour: 'var(--primary-900)',
                            lightColour: 'var(--primary-400)',
                            lightIntensity: 20,
                        ),

                        new Bloom(
                            position: BloomPosition::BottomRight,
                            spreadX: 40,
                            spreadY: 30,
                            darkIntensity: 15,
                            darkColour: 'var(--primary-950)',
                            lightColour: 'var(--primary-400)',
                            lightIntensity: 30,
                        ),
                    ])
                    ->headings()
                    ->transitions(duration: 0.825, offset: 0.825)
                    ->primaryColour(dark: '#00A36A', light: '#00B08E')
                    ->backgrounds(
                        darkBody: '#050706',
                        darkPanels: '#0A1010',
                        darkNavigation: '#0A101090',
                        lightBody: '#FBFBFB',
                        lightPanels: '#FFFFFF',
                        lightNavigation: '#FFFFFF',
                    );

                $panel
                    ->font('Inter Tight')
                    ->topbar(false);
            },

            self::Pristine => function (Theme $theme, Panel $panel) {
                $theme
                    ->blooming([
                        new Bloom(
                            position: BloomPosition::UpperLeft,
                            spreadX: 20,
                            spreadY: 70,
                            darkIntensity: 11,
                            darkColour: 'var(--primary-900)',
                            lightColour: 'var(--primary-500)',
                            lightIntensity: 20,
                        ),

                        new Bloom(
                            position: BloomPosition::UpperCenter,
                            spreadX: 80,
                            spreadY: 30,
                            darkIntensity: 20,
                            darkColour: 'var(--primary-900)',
                            lightColour: 'var(--primary-400)',
                            lightIntensity: 20,
                        ),

                        new Bloom(
                            position: BloomPosition::BottomLeft,
                            spreadX: 70,
                            spreadY: 40,
                            darkIntensity: 11,
                            darkColour: 'var(--primary-900)',
                            lightColour: 'var(--primary-400)',
                            lightIntensity: 20,
                        ),

                        new Bloom(
                            position: BloomPosition::BottomRight,
                            spreadX: 40,
                            spreadY: 30,
                            darkIntensity: 15,
                            darkColour: 'var(--primary-950)',
                            lightColour: 'var(--primary-400)',
                            lightIntensity: 30,
                        ),
                    ])
                    ->auth(AuthLayout::Editorial, tagline: 'The best company in the land!')
                    ->shadows(Shadows::Soft)
                    ->borders(style: BorderStyle::Solid, width: 1)
                    ->roundness(Roundness::Pill)
                    ->headings()
                    ->transitions(duration: 0.825, offset: 0.825)
                    ->primaryColour(dark: Color::Indigo[500], light: Color::Indigo[500])
                    ->backgrounds(
                        darkBody: '#090a12',
                        darkPanels: '#090a1290',
                        darkNavigation: '#090a1290',
                        lightBody: '#F1F5F8',
                        lightPanels: '#FFFFFF',
                        lightNavigation: '#FFFFFF',
                    );
            }
        };

        if (is_callable($callback))
            $callback($theme, $panel);
    }
}