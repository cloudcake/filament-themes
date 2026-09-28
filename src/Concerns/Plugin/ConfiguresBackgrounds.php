<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Cloudcake\Themes\Settings\Styles;
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
        array|string|null|Closure $darkBody,
        array|string|null|Closure $darkPanels,
        array|string|null|Closure $darkNavigation,
        array|string|null|Closure $lightBody,
        array|string|null|Closure $lightPanels,
        array|string|null|Closure $lightNavigation,
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
                        body {
                            background-color: $lightBodyColour;
                        }                                 
                                        
                        .fi-sidebar,
                        .fi-topbar {
                            background-color: $lightNavigationColour;
                        }
                        
                        .fi-ta-ctn,
                            .fi-sc-wizard,
                            .fi-section:not(.fi-aside):not(.fi-section-not-contained),
                            .fi-section:not(.fi-section-not-contained).fi-aside > .fi-section-content-ctn,
                            .fi-wi-stats-overview-stat {
                                background-color: $lightPanelColour;
                        }
                  
                        .dark {
                            body {
                                background-color: $darkBodyColour;
                            }
                            
                            .fi-sidebar,
                            .fi-topbar {
                                background-color: $darkNavigationColour;
                            }
                        
                            .fi-ta-ctn,
                            .fi-sc-wizard,
                            .fi-section:not(.fi-aside):not(.fi-section-not-contained),
                            .fi-section:not(.fi-section-not-contained).fi-aside > .fi-section-content-ctn,
                            .fi-wi-stats-overview-stat {
                                background-color: $darkPanelColour;
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