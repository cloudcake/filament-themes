<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Cloudcake\Themes\Enums\Shadows;
use Cloudcake\Themes\Settings\Styles;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

trait ConfiguresShadows
{
    protected Shadows $shadows = Shadows::Default;

    public function shadows(Closure|Shadows $shadows): static
    {
        $this->shadows = $shadows;

        return $this;
    }

    protected function applyShadows(Panel $panel): static
    {
        $panel->renderHook(
            PanelsRenderHook::STYLES_AFTER,
            function () use ($panel) {
                $shadowTokens = Styles::shadowTokens($panel->evaluate($this->shadows));

                return new HtmlString(
                    <<<HTML
                        <style>                    
                            :root {
                                $shadowTokens
                            }
                        </style>
                    HTML
                );
            }
        );

        return $this;
    }
}