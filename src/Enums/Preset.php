<?php

namespace Cloudcake\Themes\Enums;

use Cloudcake\Themes\Theme;
use Filament\Support\Colors\Color;

enum Preset
{
    case Default;
    case Pristine;

    public function apply(Theme $theme): void
    {
        match ($this) {
            self::Default => $theme
                ->transitions(condition: false)
                ->shadows(shadows: Shadows::Default)
                ->borders(style: BorderStyle::Default)
                ->roundness(Roundness::Default)
                ->headingIcons(condition: false),

            self::Pristine => $theme
                ->shadows(Shadows::Soft)
                ->borders(style: BorderStyle::Dotted, width: 1)
                ->roundness(Roundness::Pill)
                ->headingIcons()
                ->transitions(duration: 0.825, offset: 0.825)
                ->primaryColour(dark: Color::Lime, light: Color::Lime)
                ->background(dark: '#11111a', light: '#FFFFFF')
            ->tint(dark: '#6D8196', light: 'skyblue')
        };
    }
}