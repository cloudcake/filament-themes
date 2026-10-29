<?php

namespace Cloudcake\Themes;

use Filament\Support\Assets\Css;
use Filament\Support\Facades\FilamentAsset;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot(): void
    {
        $this->bootAssets();
        $this->bootLanguage();
        $this->bootViews();
    }

    private function bootAssets(): void
    {
        FilamentAsset::register([
            Css::make('cloudcake-theme', __DIR__ . '/../resources/dist/css/@index.css'),
        ]);
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
