<?php

namespace Cloudcake\Themes;

enum Roundness
{
    case None;
    case Slight;
    case Moderate;
    case Strong;
    case Pill;

    public function tokens() : array
    {
        return match($this) {
            self::None => [
                'radius-xs' => '0',
                'radius-sm' => '0',
                'radius-md' => '0',
                'radius-lg' => '0',
                'radius-xl' => '0',
                'radius-2xl' => '0',
                'radius-3xl' => '0',
            ],
            self::Slight => [
                'radius-xs' => '0.0625rem',
                'radius-sm' => '0.125rem',
                'radius-md' => '0.1875rem',
                'radius-lg' => '0.25rem',
                'radius-xl' => '0.375rem',
                'radius-2xl' => '0.5rem',
                'radius-3xl' => '0.625rem',
            ],
            self::Moderate => [
                'radius-xs' => '0.1875rem',
                'radius-sm' => '0.25rem',
                'radius-md' => '0.375rem',
                'radius-lg' => '0.5rem',
                'radius-xl' => '0.625rem',
                'radius-2xl' => '0.875rem',
                'radius-3xl' => '1.125rem',
            ],
            self::Strong => [
                'radius-xs' => '0.25rem',
                'radius-sm' => '0.375rem',
                'radius-md' => '0.5rem',
                'radius-lg' => '0.75rem',
                'radius-xl' => '0.9375rem',
                'radius-2xl' => '1.25rem',
                'radius-3xl' => '1.75rem',
            ],
            self::Pill => [
                'radius-xs' => '0.5rem',
                'radius-sm' => '0.75rem',
                'radius-md' => '1rem',
                'radius-lg' => '1.25rem',
                'radius-xl' => '1.75rem',
                'radius-2xl' => '2.5rem',
                'radius-3xl' => '3.75rem',
            ],
        };
    }
}