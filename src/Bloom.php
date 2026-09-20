<?php

namespace Cloudcake\Themes;

readonly class Bloom
{
    public function __construct(
        public BloomPosition $position,
        public int           $spreadX,
        public int           $spreadY
    )
    {
    }

    public function tokens() : string
    {
        $position = match($this->position) {
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

        return "$this->spreadX% $this->spreadY% at $position";
    }
}