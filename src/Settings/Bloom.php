<?php

namespace Cloudcake\Themes\Settings;

use Cloudcake\Themes\Enums\BloomPosition;

readonly class Bloom
{
    public function __construct(
        public BloomPosition $position,
        public int           $spreadX = 30,
        public int           $spreadY = 30,
        public int           $darkIntensity = 26,
        public string|null   $darkColour = 'var(--primary-900)',
        public string|null   $lightColour = 'var(--primary-500)',
        public int           $lightIntensity = 36,
    )
    {
    }

    public function positionToken(): string
    {
        $position = match ($this->position) {
            BloomPosition::UpperLeft => 'top left',
            BloomPosition::UpperCenter => 'top center',
            BloomPosition::UpperRight => 'top right',

            BloomPosition::MiddleLeft => 'left center',
            BloomPosition::MiddleCenter => 'center center',
            BloomPosition::MiddleRight => 'center right',

            BloomPosition::BottomLeft => 'bottom left',
            BloomPosition::BottomCenter => 'bottom center',
            BloomPosition::BottomRight => 'bottom right',
        };

        return "at $position";
    }

    public function spreadToken(): string
    {
        return "$this->spreadX% $this->spreadY%";
    }

    public function darkColourToken(): string
    {
        $colour = $this->darkColour ?? 'var(--primary-900)';

        return "color-mix(in oklab, $colour $this->darkIntensity%, transparent) 5%, transparent 60%)";
    }

    public function lightColourToken(): string
    {
        $colour = $this->lightColour ?? 'var(--primary-500)';

        return "color-mix(in oklab, $colour $this->lightIntensity%, transparent) 5%, transparent 70%)";
    }
}