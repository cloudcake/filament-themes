<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

trait ConfiguresArt
{
    protected Closure|string|null|false $authBackgroundIcon = "data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%2224%22%20height%3D%2224%22%20viewBox%3D%220%200%2024%2024%22%20fill%3D%22none%22%20stroke%3D%22currentColor%22%20stroke-width%3D%221%22%20stroke-linecap%3D%22round%22%20stroke-linejoin%3D%22round%22%20class%3D%22icon%20icon-tabler%20icons-tabler-outline%20icon-tabler-user-key%22%3E%0A%09%3Cpath%20stroke%3D%22none%22%20d%3D%22M0%200h24v24H0z%22%20fill%3D%22none%22%20%2F%3E%0A%09%3Cpath%20d%3D%22M8%207a4%204%200%201%200%208%200a4%204%200%200%200%20-8%200%22%20%2F%3E%0A%09%3Cpath%20d%3D%22M6%2021v-2a4%204%200%200%201%204%20-4h5%22%20%2F%3E%0A%09%3Cpath%20d%3D%22M18.5%2018.5l-3.5%203.5l-1.5%20-1.5%22%20%2F%3E%0A%09%3Cpath%20d%3D%22M18.554%2018.414a2%202%200%201%201%202.828%20-2.828a2%202%200%200%201%20-2.828%202.828%22%20%2F%3E%0A%09%3Cpath%20d%3D%22M16%2019l1%201%22%20%2F%3E%0A%3C%2Fsvg%3E";

    public function authBackgroundIcon(Closure|string|null|false $image): static
    {
        $this->authBackgroundIcon = $image;

        return $this;
    }


    protected function applyArt(Panel $panel): static
    {
        $panel->renderHook(
            PanelsRenderHook::STYLES_AFTER,
            function () use ($panel) {

                $authImage = $panel->evaluate($this->authBackgroundIcon);

                return new HtmlString(
                    <<<HTML
                    <style>
                        body {
                           --theme-icon-auth: url("$authImage");
                        }
                    </style>
                HTML
                );
            }
        );

        return $this;
    }
}
