<?php

namespace Cloudcake\Themes;

enum Shadows
{
    case None;
    case Slight;
    case Moderate;
    case Strong;
    case Dramatic;

    public function tokens(): array
    {
        return match ($this) {
            self::None => [
                'shadow-xs' => 'none',
                'shadow-sm' => 'none',
                'shadow-md' => 'none',
                'shadow-lg' => 'none',
                'shadow-xl' => 'none',
                'shadow-2xl' => 'none',
                'shadow-3xl' => 'none',
                'shadow-4xl' => 'none',
            ],
            self::Slight => [
                'shadow-2xs' => '0 1px rgb(0 0 0 / 0.05)',
                'shadow-xs' => '0 1px 2px 0 rgb(0 0 0 / 0.05)',
                'shadow-sm' => '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)',
                'shadow-md' => '0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)',
                'shadow-lg' => '0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)',
                'shadow-xl' => '0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1)',
                'shadow-2xl' => '0 25px 50px -12px rgb(0 0 0 / 0.25)',
            ],
            self::Moderate => [
                'shadow-2xs' => '0 1px rgb(0 0 0 / 0.05)',
                'shadow-xs' => '0 1px 2px 0 rgb(0 0 0 / 0.05)',
                'shadow-sm' => '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)',
                'shadow-md' => '0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)',
                'shadow-lg' => '0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)',
                'shadow-xl' => '0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1)',
                'shadow-2xl' => '0 25px 50px -12px rgb(0 0 0 / 0.25)',
            ],
            self::Strong => [
                'shadow-2xs' => '0 1px rgb(0 0 0 / 0.05)',
                'shadow-xs' => '0 1px 2px 0 rgb(0 0 0 / 0.05)',
                'shadow-sm' => '0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)',
                'shadow-md' => '0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)',
                'shadow-lg' => '0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)',
                'shadow-xl' => '0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1)',
                'shadow-2xl' => '0 25px 50px -12px rgb(0 0 0 / 0.25)',
            ],
            self::Dramatic => [
                'shadow-2xs' => '0 5px rgb(0 0 0 / 0.05)',
                'shadow-xs' => '0 5px 8px 0 rgb(0 0 0 / 0.05)',
                'shadow-sm' => '0 6px 12px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1)',
                'shadow-md' => '0 12px 18px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1)',
                'shadow-lg' => '0 30px 45px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1)',
                'shadow-xl' => '0 60px 75px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1)',
                'shadow-2xl' => '0 75px 150px -12px rgb(0 0 0 / 0.25)',
            ]
        };
    }
}