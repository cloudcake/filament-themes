<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Cloudcake\Themes\Enums\Preset;

trait ConfiguresPreset
{
    public function preset(Preset $preset): static
    {
        $preset->apply($this);

        return $this;
    }
}