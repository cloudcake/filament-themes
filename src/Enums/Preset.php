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
                    ->roundness(Roundness::Moderate)
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
                        darkPanels: '#0A101090',
                        darkNavigation: '#0A101080',
                        lightBody: '#FBFBFB',
                        lightPanels: '#FFFFFF',
                        lightNavigation: '#FFFFFF',
                    );

                $panel
                    ->font('Inter Tight')
                    ->topbar(true);
            },

            self::Pristine => function (Theme $theme, Panel $panel) {
                $theme
                    ->auth(AuthLayout::Editorial, tagline: 'The best company in the land!')
                    ->shadows(Shadows::Soft)
                    ->borders(style: BorderStyle::DashedRails, width: 12)
                    ->roundness(Roundness::Pill)
                    ->headings()
                    ->transitions(duration: 0.825, offset: 0.825)
                    ->primaryColour(dark: Color::Red[500], light: Color::Indigo[500]);
                    //->backgrounds(dark: '#020302', light: '#F1F5F8')
                    //->tint(dark: '#6D8196', light: 'skyblue');
            }
        };

        if (is_callable($callback))
            $callback($theme, $panel);
    }
}