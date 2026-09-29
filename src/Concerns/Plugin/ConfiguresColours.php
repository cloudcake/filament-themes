<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Cloudcake\Themes\Settings\Styles;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

trait ConfiguresColours
{
    protected null|array|string|Closure $darkPrimaryColour = null;
    protected null|array|string|Closure $lightPrimaryColour = null;

    public function primaryColour(array|string|null|Closure $dark, array|string|null|Closure $light): static
    {
        $this->darkPrimaryColour = $dark;
        $this->lightPrimaryColour = $light;

        return $this;
    }

    protected function applyColours(Panel $panel): static
    {
        $panel->renderHook(
            PanelsRenderHook::STYLES_AFTER,
            function () use ($panel) {
                $lightShadeTokens = '';
                $darkShadeTokens = '';

                $lightPrimaryColour = $panel->evaluate($this->lightPrimaryColour);

                if ($lightPrimaryColour) {
                    $lightPrimaryColour = $panel->evaluate($this->lightPrimaryColour);
                    $lightShadeTokens = Styles::shadeTokens($lightPrimaryColour, 'primary');
                }

                $darkPrimaryColour = $panel->evaluate($this->darkPrimaryColour);

                if ($darkPrimaryColour) {
                    $darkPrimaryColour = $panel->evaluate($this->darkPrimaryColour);

                    $darkShadeTokens = Styles::shadeTokens($darkPrimaryColour, 'primary');
                }

                return new HtmlString(
                    <<<HTML
                        <style>
                            body {
                                --livewire-progress-bar-color: $lightPrimaryColour;
                                
                                $lightShadeTokens 
                            }                    
                                                   
                            .dark body {
                                --livewire-progress-bar-color: $darkPrimaryColour;
                                
                                $darkShadeTokens
                            }
                        </style>
                    HTML
                );
            }
        );

        return $this;
    }
}