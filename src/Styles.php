<?php

namespace Cloudcake\Themes;

use Filament\Support\Colors\Color;

class Styles extends Color
{
    public const Black = [
        50 => 'oklch(0.985 0.002 247.839)',
        100 => 'oklch(0.967 0.003 264.542)',
        200 => 'oklch(0.928 0.006 264.531)',
        300 => 'oklch(0.872 0.01 258.338)',
        400 => 'oklch(0.707 0.022 261.325)',
        500 => 'oklch(0.551 0.027 264.364)',
        600 => 'oklch(0.446 0.03 256.802)',
        700 => 'oklch(0.373 0.034 259.733)',
        800 => 'oklch(0.278 0.033 256.848)',
        900 => 'oklch(0.21 0.034 264.665)',
        950 => 'oklch(0.13 0.028 261.692)',
    ];

    public static function all(): array
    {
        $base = parent::all();
        $base['black'] = static::Black;

        return $base;
    }


    private static function backgroundShades(string $colour)
    {
        if (static::isLight($colour))
            return [];

        $shades = [];

        for ($i = 3; $i < 10; $i++) {
            $mixValue = min((($i + 1) / 10) * 100, 99);
            $shades[$i * 100] = "color-mix(in oklab, $colour $mixValue%, skyblue)";
        }

        return $shades;
    }

    public static function backgroundTokens(string|Color $colour): string
    {
        $shades = static::backgroundShades($colour);

        $str = str('/* Cloudcake Background Shades */' . PHP_EOL . PHP_EOL . "\t\t");

        foreach ($shades as $shade => $value)
            $str = $str->append("--gray-$shade: $value;")->append(PHP_EOL . "\t\t");

        $str = $str->append('--theme-canvas: ' . $colour . ';')->append(PHP_EOL . "\t\t");
        $str = $str->append("background-color: $colour;")->append(PHP_EOL . "\t\t");

        return $str->toString();
    }

    public static function shadeTokens(array $shades, string $prefix): string
    {
        $str = str("/* Cloudcake '$prefix' Shades */" . PHP_EOL . PHP_EOL . "\t\t");

        foreach ($shades as $shade => $value)
            $str = $str->append("--$prefix-$shade: $value;")->append(PHP_EOL . "\t\t");

        return $str->toString();
    }

    /**
     * @param array<Bloom> $blooming
     * @return string
     */
    public static function bloomTokens(array $blooming, bool $dark): string
    {
        $str = str('/* Cloudcake Blooming */' . PHP_EOL . PHP_EOL . "\t\t")
            ->append('background-repeat: no-repeat;' . PHP_EOL . "\t\t")
            ->append('background-attachment: fixed;' . PHP_EOL . "\t\t")
            ->append('background-size: 100% 100%;' . PHP_EOL . "\t\t")
            ->append('background-image: ' . PHP_EOL . "\t\t\t\t");

        /**
         * @var int $index
         * @var Bloom $bloom
         */
        foreach ($blooming as $index => $bloom) {
            $colour = $dark ? $bloom->darkColourToken() : $bloom->lightColourToken();

            $str = $str->append("radial-gradient({$bloom->spreadToken()} {$bloom->positionToken()}, {$colour}");

            if ($index < count($blooming) - 1)
                $str = $str->append(',');
            else
                $str = $str->append(';');

            $str = $str->append(PHP_EOL . "\t\t\t\t");
        }

        return $str->toString();
    }

    public static function roundnessTokens(Roundness $roundness): string
    {
        $str = str('/* Cloudcake Roundness */' . PHP_EOL . PHP_EOL . "\t\t");

        foreach ($roundness->tokens() as $variable => $value)
            $str = $str->append("--$variable: $value;" . PHP_EOL . "\t\t");

        return $str->toString();
    }

    public static function shadowTokens(Shadows $shadows): string
    {
        $str = str('/* Cloudcake Shadows */' . PHP_EOL . PHP_EOL . "\t\t");

        foreach ($shadows->tokens() as $variable => $value)
            $str = $str->append("--$variable: $value;" . PHP_EOL . "\t\t");

        return $str->toString();
    }

    private static function selectorRules(
        array  $selects = [],
        array  $modifiers = [],
        string $comment = 'Cloudcake Modifications'): string
    {
        $str = str("/* $comment */" . PHP_EOL . PHP_EOL . "\t\t");

        foreach ($selects as $name => $selectors) {

            $end = count($selectors);

            foreach ($selectors as $index => $selector) {
                $str = $str->append($selector);

                if ($index < $end - 1)
                    $str = $str->append(',' . PHP_EOL . "\t\t");
            }

            $str = $str->append(' {' . PHP_EOL . "\t\t\t");

            $end = count($modifiers[$name]);

            foreach ($modifiers[$name] as $index => $modifier) {
                $str = $str->append($modifier . PHP_EOL);

                if ($index < $end - 1)
                    $str = $str->append("\t\t\t");
            }

            $str = $str->append("\t\t}" . PHP_EOL . "\t\t");
        }

        return $str->toString();
    }

    public static function borderRails(bool $active, bool $dark): string
    {
        if (!$active)
            return '';

        $colour = $dark ? '--gray-700' : '--primary-200';
        $opacityOuter = $dark ? '30' : 80;
        $opacityInner = $dark ? '20' : 50;

        $selects = [
            'rails' => [
                '.fi-wi-stats-overview-stat',
                '.fi-ta-ctn',
                '.fi-main-ctn',
                '.fi-sc-wizard',
                '.fi-section:not(:has(.fi-wi-stats-overview-stat)):not(.fi-aside):not(.fi-section-not-contained)',
                '.fi-section:not(.fi-section-not-contained).fi-aside > .fi-section-content-ctn',
                '.fi-section:not(.fi-section-not-contained).fi-aside > .fi-section-content-ctn:where(.dark,.dark *)',
            ],
            'borderless' => [
                '.fi-sidebar',
                '.fi-topbar',
            ]
        ];

        $modifiers = [
            'rails' => [
                '--tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);',
                '--tw-outline-style: double;',
                "border: 1px solid color-mix(in oklab, var($colour) $opacityOuter%, transparent) !important;",
                'outline-offset: -8px;',
                'outline-width: 1px;',
                "outline-color: color-mix(in oklab, var($colour) $opacityInner%, transparent) !important;",
                'outline-style: double;',
            ],
            'borderless' => [
                'border: none;',
            ]
        ];

        return static::selectorRules($selects, $modifiers,'Cloudcake Border Rails');
    }

    public static function pageTransitions(bool $active, float $duration = 1.5, float $offset = 1.5): string
    {
        if (!$active)
            return '';

        $selects = [
            'targets' => [
                '.fi-body .fi-main > .fi-page, .fi-body .fi-simple-main'
            ],
            'keyframes' => [
                '@keyframes theme-rise'
            ]
        ];

        $modifiers = [
            'targets' => [
                "animation: theme-rise {$duration}s;",
            ],
            'keyframes' => [
                "from {opacity: 0; transform: translateY({$offset}rem);}",
                'to {opacity: 1; transform: translateY(0);}'
            ]
        ];

        return static::selectorRules($selects, $modifiers, 'Cloudcake Page Transitions');
    }
}