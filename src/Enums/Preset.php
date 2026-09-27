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
                ->headings(icon: false, underline: false),

            self::Pristine => $theme
                ->shadows(Shadows::Soft)
                ->borders(style: BorderStyle::Dotted, width: 2)
                ->roundness(Roundness::Pill)
                ->headings()
                ->transitions(duration: 0.825, offset: 0.825)
                ->primaryColour(dark: Color::Lime, light: Color::Lime)
                ->background(dark: '#11111a', light: '#FFFFFF')
                ->auth(AuthLayout::Editorial, tagline: 'Welcome to the universe!')
            ->tint(dark: '#6D8196', light: 'skyblue')
        };
    }
}