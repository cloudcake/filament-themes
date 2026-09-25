<?php

namespace Cloudcake\Themes;

use Cloudcake\Themes\Livewire\DatabaseNotifications;
use Livewire\Livewire;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot(): void
    {
        $this->bootLanguage();
        $this->bootViews();
        $this->bootLivewire();
    }

    private function bootLanguage(): void
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'cloudcake-themes');
    }

    private function bootViews(): void
    {
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'cloudcake-themes');
    }

    private function bootLivewire() : void
    {
        Livewire::component('filament-notifications-tabs.database-notifications', DatabaseNotifications::class);
    }
}