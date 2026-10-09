<?php

namespace Cloudcake\Themes;

use Cloudcake\Themes\Livewire\DatabaseNotifications;
use Livewire\Livewire;

use Filament\Support\Assets\Theme as FilamentTheme;
use Filament\Support\Facades\FilamentAsset;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot(): void
    {
        $this->bootLanguage();
        $this->bootViews();
        $this->bootAssets();
    }

    /**
     * Registered as a Filament theme rather than a plain stylesheet, so a panel can use it in place of
     * Filament's default theme. A plain stylesheet loads before the default theme, which then puts the
     * default borders and spacing back.
     */
    private function bootAssets(): void
    {
        FilamentAsset::register([
            FilamentTheme::make(Theme::ASSET_ID, __DIR__ . '/../resources/dist/css/index.css'),
        ], 'cloudcake/filament-themes');
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