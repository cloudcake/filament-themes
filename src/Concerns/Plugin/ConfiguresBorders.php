<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Cloudcake\Themes\Enums\BorderStyle;
use Cloudcake\Themes\Enums\Roundness;
use Cloudcake\Themes\Settings\Styles;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

trait ConfiguresBorders
{
    protected BorderStyle $borderStyle = BorderStyle::Default;
    protected Roundness $roundness = Roundness::Default;

    protected int $borderWidth = 11;

    public function borders(Closure|BorderStyle $style, Closure|Roundness $roundness = Roundness::Default, int $width = 8): static
    {
        $this->borderStyle = $style;
        $this->borderWidth = $width;
        $this->roundness = $roundness;

        return $this;
    }

    public function roundness(Closure|Roundness $roundness): static
    {
        $this->roundness = $roundness;

        return $this;
    }

    protected function applyBorders(Panel $panel): static
    {
        $panel->renderHook(
            PanelsRenderHook::BODY_START,
            function () {
                $borderStyle = strtolower($this->borderStyle->name);

                return new HtmlString("<script>document.body.classList.add('theme-borders-$borderStyle');</script>");
            },
        );

        $panel->renderHook(
            PanelsRenderHook::STYLES_AFTER,
            function () use ($panel) {
                $borderRoundnessTokens = Styles::roundnessTokens($panel->evaluate($this->roundness));
                $borderWidthToken = "--theme-border-width: {{$this->borderWidth}}px;";

                return new HtmlString(
                    <<<HTML
                    <style>                    
                        :root {
                            $borderRoundnessTokens 
                            $borderWidthToken
                        }
                    </style>
                HTML
                );
            }
        );

        return $this;
    }
}