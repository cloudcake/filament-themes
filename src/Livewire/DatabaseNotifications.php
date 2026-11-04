<?php

namespace Cloudcake\Themes\Livewire;

use Cloudcake\Icons\Enums\Tabler;
use Filament\Actions\Action;
use Filament\Livewire\DatabaseNotifications as BaseDatabaseNotifications;
use Filament\Notifications\Notification;
use Filament\Support\Components\Attributes\Exposed;
use Filament\Support\Enums\Size;
use Filament\Support\Icons\Heroicon;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Support\Str;

class DatabaseNotifications extends BaseDatabaseNotifications
{
    public static string $defaultTab = 'unread';

    public static bool $confirmDelete = false;

    public string $tab = 'unread';

    public static function defaultTab(string $tab): void
    {
        static::$defaultTab = $tab;
    }

    public static function confirmDelete(bool $condition = true): void
    {
        static::$confirmDelete = $condition;
    }

    public function mount(): void
    {
        $this->tab = static::$defaultTab;
    }

    public function setTab(string $tab): void
    {
        if (!in_array($tab, ['unread', 'all'], true)) {
            return;
        }

        $this->tab = $tab;
        $this->resetPage(pageName: 'database-notifications-page');
    }

    public function getFilteredNotificationsQuery(): Builder|Relation
    {
        $query = $this->getNotificationsQuery();

        if ($this->tab === 'unread') {
            $query->whereNull('read_at');
        }

        return $query;
    }

    public function getNotifications(): DatabaseNotificationCollection|Paginator
    {
        if (!$this->isPaginated()) {
            /** @phpstan-ignore-next-line */
            return $this->getFilteredNotificationsQuery()->get();
        }

        return $this->getFilteredNotificationsQuery()->simplePaginate(15, pageName: 'database-notifications-page');
    }

    public function getAllNotificationsCount(): int
    {
        return $this->getNotificationsQuery()->count();
    }

    public function deleteNotificationAction(): Action
    {
        return Action::make('deleteNotification')
            ->label(__('cloudcake-themes::notifications.actions.delete.label'))
            ->color('danger')
            ->icon(Heroicon::OutlinedTrash)
            ->requiresConfirmation(static::$confirmDelete)
            ->action(function (array $arguments): void {
                $this->deleteNotification($arguments['id'] ?? '');
            });
    }

    public function deleteNotification(string $id): void
    {
        if (!Str::isUuid($id)) {
            return;
        }

        $this->getNotificationsQuery()
            ->where('id', $id)
            ->delete();
    }

    public function toggleNotificationReadStatus(string $id): void
    {
        if (!Str::isUuid($id)) {
            return;
        }

        $notification = $this->getNotificationsQuery()
            ->where('id', $id)
            ->first();

        $notification?->update([
            'read_at' => $notification->read_at ? null : now(),
        ]);
    }

    public function render(): View
    {
        return view('cloudcake-themes::database-notifications');
    }

    #[Exposed]
    public function markAllNotificationsAsRead(): void
    {
        parent::markAllNotificationsAsRead();

        Notification::make()
            ->title("Notifications Cleared")
            ->body("All your unread notifications have been marked as read.")
            ->icon(Tabler::Check)
            ->color('primary')
            ->send();
    }
}
