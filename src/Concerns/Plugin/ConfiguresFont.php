<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Filament\Panel;

trait ConfiguresFont
{
    protected string|Closure|null $font = null;

    public function font(string|Closure $font): static
    {
        $this->font = $font;

        return $this;
    }

    protected function applyFont(Panel $panel) : static
    {
        $panel->font($this->font);

        return $this;
    }
}