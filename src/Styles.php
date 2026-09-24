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


    private static function backgroundShades(string $colour, string $tint = 'skyblue')
    {
        if (static::isLight($colour))
            return [];

        $shades = [];

        $clamp = 94;

        for ($i = 5; $i < 10; $i++) {
            $mixValue = min(($i / 9) * $clamp, $clamp);
            $shades[$i * 100] = "color-mix(in oklab, $colour $mixValue%, $tint)";
        }

        return $shades;
    }

    public static function backgroundTokens(string|Color $colour, string|Color $tint): string
    {
        $shades = static::backgroundShades($colour, $tint);

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

    public static function transitionTokens(float $duration, float $offset): string
    {
        return str('/* Cloudcake Transitions */' . PHP_EOL . PHP_EOL . "\t\t")
            ->append("--theme-transition-duration: {$duration}s;")->append(PHP_EOL . "\t\t")
            ->append("--theme-transition-offset: {$offset}rem;")->append(PHP_EOL . "\t\t")
            ->toString();
    }

    /**
     * @param array<Bloom> $blooming
     * @param bool $dark
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
            $str = $str->append("--$variable: $value var(--theme-shadow-colour);" . PHP_EOL . "\t\t");

        return $str->toString();
    }
}