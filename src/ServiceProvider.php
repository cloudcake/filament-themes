<?php

namespace Cloudcake\Themes;


use Filament\Support\Assets\Theme as FilamentTheme;
use Filament\Support\Facades\FilamentAsset;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot(): void
    {
        $this->bootLanguage();
        $this->bootViews();
    }

    private function bootLanguage(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'cloudcake-themes');
    }

    private function bootViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cloudcake-themes');
    }
}
