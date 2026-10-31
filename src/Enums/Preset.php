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
            self::Pristine => $this->prestineBase($theme)
                ->primaryColour(dark: Color::Indigo[500], light: Color::Indigo[500])
                ->backgrounds(
                    darkBody: '#090a12',
                    darkPanels: '#090a1220',
                    darkNavigation: '#090a1220',
                    lightBody: '#e8f2fa',
                    lightPanels: '#FFFFFF20',
                    lightNavigation: '#FFFFFF50',
                ),

            self::PristineGreen => $this->prestineBase($theme)
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

    protected function prestineBase(Theme $theme)
    {
        return $theme
            ->font('Inter Tight')
            ->blooming([
                new Bloom(
                    position: BloomPosition::MiddleCenter,
                    spreadX: 110,
                    spreadY: 110,
                    darkIntensity: 14,
                    darkColour: 'var(--primary-900)',
                    lightColour: 'var(--primary-500)',
                    lightIntensity: 14,
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
