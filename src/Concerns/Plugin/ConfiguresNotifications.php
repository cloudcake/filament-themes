<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Cloudcake\Themes\Livewire\DatabaseNotifications;
use Filament\Panel;
use Livewire\Livewire;

trait ConfiguresNotifications
{
    protected function applyNotifications(Panel $panel): static
    {
        $panel->when(
            fn(Panel $panel) => $panel->hasDatabaseNotifications(),
            function (Panel $panel) {
                Livewire::component('filament-notifications-tabs.database-notifications', DatabaseNotifications::class);

                DatabaseNotifications::defaultTab('unread');
                DatabaseNotifications::confirmDelete();

                $panel->databaseNotificationsLivewireComponent(DatabaseNotifications::class);
            }
        );

        return $this;
    }
}