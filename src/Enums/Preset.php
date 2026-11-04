<?php

namespace Cloudcake\Themes\Enums;

use Cloudcake\Themes\Settings\Bloom;
use Cloudcake\Themes\Theme;
use Filament\Support\Colors\Color;

enum Preset
{
    case Pristine;
    case PristineGreen;

    public function apply(Theme $theme): void
    {
        match ($this) {
            self::Pristine => $this->pristineBase($theme)
                ->primaryColour(dark: Color::Indigo[500], light: Color::Indigo[500])
                ->backgrounds(
                    darkBody: '#090a12',
                    darkPanels: '#090a1220',
                    darkNavigation: '#090a1250',
                    lightBody: '#e8f2fa',
                    lightPanels: '#FFFFFF20',
                    lightNavigation: '#FFFFFF50',
                ),

            self::PristineGreen => $this->pristineBase($theme)
                ->primaryColour(dark: Color::Green[500], light: Color::Green[600])
                ->backgrounds(
                    darkBody: '#000000',
                    darkPanels: '#090a1220',
                    darkNavigation: '#00000020',
                    lightBody: '#f3faff',
                    lightPanels: '#FFFFFF20',
                    lightNavigation: '#FFFFFF20',
                )
        };
    }

    protected function pristineBase(Theme $theme)
    {
        return $theme
            ->font('Inter Tight')
            ->blooming([
                new Bloom(
                    position: BloomPosition::UpperCenter,
                    spreadX: 100,
                    spreadY: 50,
                    darkIntensity: 2,
                    darkColour: 'var(--primary-300)',
                    lightColour: 'var(--primary-500)',
                    lightIntensity: 4,
                ),

                new Bloom(
                    position: BloomPosition::BottomCenter,
                    spreadX: 100,
                    spreadY: 60,
                    darkIntensity: 2,
                    darkColour: 'var(--primary-300)',
                    lightColour: 'var(--primary-500)',
                    lightIntensity: 4,
                ),
            ])
            ->auth(layout: AuthLayout::Editorial, tagline: null)
            ->shadows(Shadows::Soft)
            ->borders(style: BorderStyle::Solid, width: 1)
            ->roundness(Roundness::Pill)
            ->headings()
            ->transitions(duration: 0.825, offset: 0.825);
    }
}
