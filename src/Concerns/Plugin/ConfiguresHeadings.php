<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Cloudcake\Themes\Enums\AuthLayout;
use Filament\Panel;
use Filament\View\PanelsRenderHook;

trait ConfiguresHeadings
{
    protected bool|Closure $headingIcons = false;
    protected bool|Closure $headingUnderline = false;
    protected string|Closure|array $headingIconColour = 'light-dark(var(--gray-700), var(--gray-700))';
    protected string|Closure|array $headingUnderlineColour = 'light-dark(var(--primary-500), var(--primary-500))';
    protected string|Closure|null $headingIconSize = '1.5rem';
    protected string|Closure|null $headingUnderlineThickness = '0.125rem';
    protected string|Closure|null $headingUnderlineLength = '100%';

    public function headings(
        bool|Closure         $icon = true,
        bool|Closure         $underline = true,
        string|Closure|array $iconColour = 'light-dark(var(--gray-700), var(--gray-700))',
        string|Closure|array $underlineColour = 'light-dark(var(--primary-500), var(--primary-500))',
    ): static
    {
        $this->headingIcons = $icon;
        $this->headingIconColour = $iconColour;
        $this->headingUnderline = $underline;
        $this->headingUnderlineColour = $underlineColour;

        return $this;
    }

    protected function applyHeadings(Panel $panel): static
    {
        $panel->when(
            fn($panel) => $panel->evaluate($this->headingIcons),
            fn($panel) => $panel
                ->renderHook(
                    PanelsRenderHook::PAGE_HEADER_HEADING_BEFORE,
                    fn() => view('cloudcake-themes::hooks.heading', [
                        'iconColour' => $panel->evaluate($this->headingIconColour),
                        'iconSize' => $panel->evaluate($this->headingIconSize),
                    ])
                )
                ->renderHook(
                    PanelsRenderHook::STYLES_AFTER,
                    fn() => view('cloudcake-themes::hooks.style-heading-icon', [
                        'iconColour' => $panel->evaluate($this->headingIconColour),
                        'iconSize' => $panel->evaluate($this->headingIconSize),
                    ])
                ),
        );

        $panel->when(
            fn($panel) => $panel->evaluate($this->headingUnderline),
            fn($panel) => $panel
                ->renderHook(
                    PanelsRenderHook::STYLES_AFTER,
                    fn() => view('cloudcake-themes::hooks.style-heading-underline', [
                        'underlineColour' => $panel->evaluate($this->headingUnderlineColour),
                        'underlineThickness' => $panel->evaluate($this->headingUnderlineThickness),
                        'underlineLength' => $panel->evaluate($this->headingUnderlineLength),
                    ])
                ),
        );

        return $this;
    }
}