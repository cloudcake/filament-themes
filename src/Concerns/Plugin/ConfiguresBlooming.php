<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Cloudcake\Themes\Settings\Styles;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

trait ConfiguresBlooming
{
    protected array|false|Closure $blooming = false;

    public function blooming(Closure|array|bool $blooming = true): static
    {
        $this->blooming = $blooming;

        return $this;
    }

    protected function applyBlooming(Panel $panel): static
    {
        $panel->renderHook(
            PanelsRenderHook::STYLES_AFTER,
            function () use ($panel) {
                $lightBloomTokens = '';
                $darkBloomTokens = '';

                $blooming = $panel->evaluate($this->blooming);

                if ($blooming !== false) {
                    $lightBloomTokens = Styles::bloomTokens($blooming, dark: false);
                    $darkBloomTokens = Styles::bloomTokens($blooming, dark: true);
                }

                return new HtmlString(
                    <<<HTML
                    <style>                    
                        .fi-layout {
                            $lightBloomTokens
                        }
                    
                        .dark .fi-layout {
                            $darkBloomTokens
                        }
                    </style>
                HTML
                );
            }
        );

        return $this;
    }
}