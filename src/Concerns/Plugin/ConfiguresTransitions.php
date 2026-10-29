<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Cloudcake\Themes\Settings\Styles;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

trait ConfiguresTransitions
{
    protected bool|Closure $pageTransitions = false;
    protected float|Closure $pageTransitionDuration = 0.5;
    protected float|Closure $pageTransitionOffset = 1.5;

    public function transitions(bool|Closure $condition = true, float|Closure $duration = 0.5, float|Closure $offset = 1.5): static
    {
        $this->pageTransitions = $condition;
        $this->pageTransitionDuration = $duration;
        $this->pageTransitionOffset = $offset;

        return $this;
    }

    protected function applyTransitions(Panel $panel): static
    {
        $panel->when(
            fn($panel) => $panel->evaluate($this->pageTransitions),
            fn($panel) => $panel
                ->renderHook(
                    PanelsRenderHook::BODY_START,
                    fn() => new HtmlString('<script>document.body.classList.add("theme-transitions");</script>'),
                )->renderHook(
                    PanelsRenderHook::STYLES_AFTER,
                    function () use ($panel) {
                        $transitionDuration = $panel->evaluate($this->pageTransitionDuration);
                        $transitionOffset = $panel->evaluate($this->pageTransitionOffset);
                        $transitionTokens = Styles::transitionTokens($transitionDuration, $transitionOffset);

                        return new HtmlString(
                            <<<HTML
                                <style>
                                    :root {
                                        $transitionTokens
                                    }
                                </style>
                            HTML
                        );
                    }
                )
        );

        return $this;
    }
}
