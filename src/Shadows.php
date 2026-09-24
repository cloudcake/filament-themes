<?php

namespace Cloudcake\Themes;

enum Shadows
{
    case None;
    case Default;
    case Moderate;
    case Strong;
    case Dramatic;

    public function tokens(): array
    {
        return match ($this) {
            self::None => [
                'shadow-xs' => 'var(--shadow-none)',
                'shadow-sm' => 'var(--shadow-none)',
                'shadow-md' => 'var(--shadow-none)',
                'shadow-lg' => 'var(--shadow-none)',
                'shadow-xl' => 'var(--shadow-none)',
                'shadow-2xl' => 'var(--shadow-none)',
                'shadow-3xl' => 'var(--shadow-none)',
                'shadow-4xl' => 'var(--shadow-none)',
            ],
            self::Default => [
                'shadow-2xs' => '0 1px 0 0',
                'shadow-xs' => '0 1px 2px 0',
                'shadow-sm' => '0 1px 3px 0',
                'shadow-md' => '0 4px 6px -1px',
                'shadow-lg' => '0 10px 15px -3px',
                'shadow-xl' => '0 20px 25px -5px',
                'shadow-2xl' => '0 25px 50px -12px',
            ],
            self::Moderate => [
                'shadow-2xs' => '0 2px rgb(0 0 0 / 0.05)',
                'shadow-xs' => '0 2px 4px 0 rgb(0 0 0 / 0.05)',
                'shadow-sm' => '0 2px 6px 0 rgb(0 0 0 / 0.07), 0 1px 2px -1px rgb(0 0 0 / 0.07)',
                'shadow-md' => '0 8px 12px -2px rgb(0 0 0 / 0.07), 0 4px 8px -4px rgb(0 0 0 / 0.07)',
                'shadow-lg' => '0 20px 30px -6px rgb(0 0 0 / 0.07), 0 8px 12px -8px rgb(0 0 0 / 0.07)',
                'shadow-xl' => '0 40px 50px -10px rgb(0 0 0 / 0.07), 0 16px 20px -12px rgb(0 0 0 / 0.07)',
                'shadow-2xl' => '0 50px 100px -24px rgb(0 0 0 / 0.25)',
            ],
            self::Strong => [
                'shadow-2xs' => '0 3px',
                'shadow-xs' => '0 4px 8px',
                'shadow-sm' => '0 4px 12px',
                'shadow-md' => '0 16px 24px -2px',
                'shadow-lg' => '0 40px 60px -6px',
                'shadow-xl' => '0 80px 100px -10px',
                'shadow-2xl' => '0 100px 200px -48px',
            ],
            self::Dramatic => [
                'shadow-2xs' => '0 3px 0',
                'shadow-xs' => '0 4px 8px',
                'shadow-sm' => '0 4px 12px',
                'shadow-md' => '0 16px 24px',
                'shadow-lg' => '0 40px 60px',
                'shadow-xl' => '0 80px 100px',
                'shadow-2xl' => '0 100px 200px',
            ]
        };
    }
}