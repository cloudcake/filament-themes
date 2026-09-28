<?php

namespace Cloudcake\Themes\Settings;

use Cloudcake\Themes\Enums\Roundness;
use Cloudcake\Themes\Enums\Shadows;
use Filament\Support\Colors\Color;

class Styles
{
    private static function backgroundShades(string $colour, string $tint = 'skyblue'): array
    {
        if (Color::isLight($colour))
            return [];

        $shades = [];

        $clamp = 90;

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

    public static function shadeTokens(string $color, string $prefix): string
    {
        $color = trim($color);

        $shades = [];
        $shades[50] = "color-mix(in oklab, $color 30%, #FFFFFF)";
        $shades[100] = "color-mix(in oklab, $color 40%, #FFFFFF)";
        $shades[200] = "color-mix(in oklab, $color 60%, #FFFFFF)";
        $shades[300] = "color-mix(in oklab, $color 80%, #FFFFFF)";
        $shades[400] = "color-mix(in oklab, $color 90%, #FFFFFF)";
        $shades[500] = $color;
        $shades[600] = "color-mix(in oklab, $color 90%, #000000)";
        $shades[700] = "color-mix(in oklab, $color 80%, #000000)";
        $shades[800] = "color-mix(in oklab, $color 70%, #000000)";
        $shades[900] = "color-mix(in oklab, $color 60%, #000000)";
        $shades[950] = "color-mix(in oklab, $color 50%, #000000)";

        $str = str("/* Cloudcake '$prefix' Shades */" . PHP_EOL . PHP_EOL . "\t\t");

        foreach ($shades as $shade => $value)
            $str = $str->append("--$prefix-$shade: $value;")->append(PHP_EOL . "\t\t");

        return $str->toString();
    }

    public static function shadowTokens(Shadows $shadows): string
    {
        $str = str('/* Cloudcake Shadows */' . PHP_EOL . PHP_EOL . "\t\t");

        foreach ($shadows->tokens() as $variable => $value)
            $str = $str->append("--runtime-$variable: $value;" . PHP_EOL . "\t\t");

        return $str->toString();
    }

    public static function transitionTokens(float $duration, float $offset): string
    {
        return str('/* Cloudcake Transitions */' . PHP_EOL . PHP_EOL . "\t\t")
            ->append("--theme-transition-duration: {$duration}s;")->append(PHP_EOL . "\t\t")
            ->append("--theme-transition-offset: {$offset}rem;")->append(PHP_EOL . "\t\t")
            ->toString();
    }
}