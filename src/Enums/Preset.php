<?php

namespace Cloudcake\Themes\Enums;

use Cloudcake\Themes\Settings\Bloom;
use Cloudcake\Themes\Theme;
use Filament\Support\Colors\Color;

enum Preset
{
    case Pristine;

    public function apply(Theme $theme): void
    {
        match ($this) {
            self::Pristine => $theme
                ->font('Inter Tight')
                ->blooming([
                    new Bloom(
                        position: BloomPosition::UpperLeft,
                        spreadX: 20,
                        spreadY: 40,
                        darkIntensity: 11,
                        darkColour: 'var(--primary-900)',
                        lightColour: 'var(--primary-500)',
                        lightIntensity: 20,
                    ),

                    new Bloom(
                        position: BloomPosition::UpperCenter,
                        spreadX: 80,
                        spreadY: 30,
                        darkIntensity: 24,
                        darkColour: 'var(--primary-900)',
                        lightColour: 'var(--primary-400)',
                        lightIntensity: 20,
                    ),

                    new Bloom(
                        position: BloomPosition::BottomLeft,
                        spreadX: 20,
                        spreadY: 40,
                        darkIntensity: 15,
                        darkColour: 'var(--primary-900)',
                        lightColour: 'var(--primary-400)',
                        lightIntensity: 20,
                    ),

                    new Bloom(
                        position: BloomPosition::BottomRight,
                        spreadX: 40,
                        spreadY: 30,
                        darkIntensity: 7,
                        darkColour: 'var(--primary-700)',
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
                    darkPanels: '#090a12',
                    darkNavigation: '#00000020',
                    lightBody: '#F1F5F8',
                    lightPanels: '#FFFFFF',
                    lightNavigation: '#FFFFFF50',
                )
        };
    }
}
