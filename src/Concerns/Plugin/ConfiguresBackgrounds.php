<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

trait ConfiguresBackgrounds
{
    protected null|array|string|Closure $darkBodyColour = null;
    protected null|array|string|Closure $darkPanelColour = null;
    protected null|array|string|Closure $darkNavigationColour = null;
    protected null|array|string|Closure $lightBodyColour = null;
    protected null|array|string|Closure $lightPanelColour = null;
    protected null|array|string|Closure $lightNavigationColour = null;

    public function backgrounds(
        array|string|null|Closure $darkBody = null,
        array|string|null|Closure $darkPanels = null,
        array|string|null|Closure $darkNavigation = null,
        array|string|null|Closure $lightBody = null,
        array|string|null|Closure $lightPanels = null,
        array|string|null|Closure $lightNavigation = null,
    ): static
    {
        $this->darkBodyColour = $darkBody;
        $this->darkPanelColour = $darkPanels;
        $this->darkNavigationColour = $darkNavigation;

        $this->lightBodyColour = $lightBody;
        $this->lightPanelColour = $lightPanels;
        $this->lightNavigationColour = $lightNavigation;

        return $this;
    }

    protected function applyBackgrounds(Panel $panel): static
    {
        $panel->renderHook(
            PanelsRenderHook::STYLES_AFTER,
            function () use ($panel) {
                $lightBodyColour = $panel->evaluate($this->lightBodyColour);
                $lightPanelColour = $panel->evaluate($this->lightPanelColour);
                $lightNavigationColour = $panel->evaluate($this->lightNavigationColour);

                $darkBodyColour = $panel->evaluate($this->darkBodyColour);
                $darkPanelColour = $panel->evaluate($this->darkPanelColour);
                $darkNavigationColour = $panel->evaluate($this->darkNavigationColour);

                return new HtmlString(
                    <<<HTML
                    <style>                                 
                        body:not(.dark body) {
                            --theme-navigation-background-color: $lightNavigationColour;
                            --color-white: $lightPanelColour;
                            --gray-50: $lightPanelColour;
                            
                            background-color: $lightBodyColour;
                            
                            .fi-sidebar,
                            .fi-topbar {
                                background-color: $lightNavigationColour;
                            }
                        }                                 
                  
                        .dark body {
                            --theme-navigation-background-color: $darkNavigationColour;
                            --color-white: #fff;
                            --gray-900: $darkPanelColour;
                            
                            background-color: $darkBodyColour;
                                                       
                            .fi-sidebar,
                            .fi-topbar {
                                background-color: $darkNavigationColour;
                            }
                        }
                    </style>
                HTML
                );
            }
        );

        return $this;
    }
}