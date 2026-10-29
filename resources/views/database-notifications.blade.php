@php
    use Filament\Support\Enums\Alignment;
    use Filament\Support\View\ComponentAttributeBag as FilamentComponentAttributeBag;
    use Filament\Support\View\Components\BadgeComponent;
    use Filament\Support\Icons\Heroicon;

    $notifications = $this->getNotifications();
    $unreadNotificationsCount = $this->getUnreadNotificationsCount();
    $hasNotifications = $notifications->count();
    $isPaginated = $notifications instanceof \Illuminate\Contracts\Pagination\Paginator && $notifications->hasPages();
    $pollingInterval = $this->getPollingInterval();

    // When delete confirmation is enabled, do NOT teleport the modal to <body>:
    // the confirmation modal renders in place, so both must share the same stacking
    // context for it to appear above the slide-over. Otherwise keep the default teleport.
    $confirmDelete = $this::$confirmDelete;
@endphp

<div class="fi-no-database">
    <x-filament::modal
            :alignment="Alignment::Center"
            aria-labelledby="database-notifications.heading"
            close-button
            :description="$hasNotifications ? null : __('filament-notifications::database.modal.empty.description')"
            :extra-modal-window-attribute-bag="
            new FilamentComponentAttributeBag([
                'autofocus' => true,
                'tabindex' => '-1',
            ])
        "
            :heading="$hasNotifications ? null : __('filament-notifications::database.modal.empty.heading')"
            :icon="$hasNotifications ? null : \Filament\Support\Icons\Heroicon::OutlinedBellSlash"
            :icon-alias="
            $hasNotifications
            ? null
            : \Filament\Notifications\View\NotificationsIconAlias::DATABASE_MODAL_EMPTY_STATE
        "
            :icon-color="$hasNotifications ? null : 'gray'"
            id="database-notifications"
            slide-over
            :sticky-header="$hasNotifications"
            teleport="body"
            width="md"
            class="fi-no-database"
            :attributes="
            new FilamentComponentAttributeBag([
                'wire:poll.' . $pollingInterval => $pollingInterval ? '' : false,
            ])
        "
    >
        @if ($trigger = $this->getTrigger())
            <x-slot name="trigger">
                {{ $trigger->with(['unreadNotificationsCount' => $unreadNotificationsCount]) }}
            </x-slot>
        @endif

        <x-slot name="header">
            <div class="flex-1">
                <h2 class="fi-modal-heading">
                    {{ __('filament-notifications::database.modal.heading') }}

                    @if ($unreadNotificationsCount)
                        <span
                            {{
                                (new FilamentComponentAttributeBag)->color(BadgeComponent::class, 'primary')->class([
                                    'fi-badge fi-size-xs',
                                ])
                            }}
                        >
                            {{ $unreadNotificationsCount }}
                        </span>
                    @endif
                </h2>

                <div class="-mx-3">
                    <x-filament::tabs contained class="fi-no-database-tabs border-b-0 mb-0 pb-0">
                        <x-filament::tabs.item
                                :active="$this->tab === 'unread'"
                                :badge="$unreadNotificationsCount ?: null"
                                icon="tabler-mail-filled"
                                wire:click="setTab('unread')"
                        >
                            {{ __('cloudcake-themes::notifications.tabs.unread') }}
                        </x-filament::tabs.item>

                        <x-filament::tabs.item
                                :active="$this->tab === 'all'"
                                icon="tabler-mail-opened"
                                wire:click="setTab('all')"
                        >
                            {{ __('cloudcake-themes::notifications.tabs.all') }}
                        </x-filament::tabs.item>

                        @if ($this->markAllNotificationsAsReadAction?->isVisible() && $unreadNotificationsCount)
                            <x-filament::tabs.item
                                class="flex-inline justify-center my-auto ms-auto leading-9"
                                :active="$this->tab === 'all'"
                                icon="{{ \Cloudcake\Components\Enums\Tabler::BellCheck }}"
                                wire:click="markAllNotificationsAsRead()"
                            >
                                {{ __('filament-notifications::database.modal.actions.mark_all_as_read.label') }}
                            </x-filament::tabs.item>
                        @endif
                    </x-filament::tabs>
                </div>
            </div>
        </x-slot>

        @if ($hasNotifications)
            @foreach ($notifications as $notification)
                <div
                        @class([
                            'fi-no-database-notification-ctn',
                            'fi-no-notification-read-ctn' => ! $notification->unread(),
                            'fi-no-notification-unread-ctn' => $notification->unread(),
                        ])
                >
                    {{ $this->getNotification($notification)->inline() }}

                    @if($notification->unread())
                        <x-filament::badge class="fi-no-database-notification-badge" color="primary">
                            Unread
                        </x-filament::badge>
                    @endif

                    <div class="fi-no-database-notification-actions">
{{--                        <x-filament::button--}}
{{--                                :icon="Heroicon::OutlinedTrash"--}}
{{--                                color="danger"--}}
{{--                                size="sm"--}}
{{--                                :label="__('cloudcake-themes::notifications.actions.delete.label')"--}}
{{--                                :tooltip="__('cloudcake-themes::notifications.actions.delete.label')"--}}
{{--                                wire:click="mountAction('deleteNotification', { id: '{{ $notification->getKey() }}' })"--}}
{{--                        />--}}

                        <x-filament::button
                                :icon="$notification->unread() ? 'tabler-mail-opened' : 'tabler-mail-filled'"
                                color="gray"
                                size="xs"
                                wire:click="toggleNotificationReadStatus('{{ $notification->getKey() }}')"
                                class="border-none"
                        >
                            {{ $notification->unread()
                                ? __('cloudcake-themes::notifications.actions.mark_as_read.label')
                                : __('cloudcake-themes::notifications.actions.mark_as_unread.label') }}
                        </x-filament::button>
                    </div>
                </div>
            @endforeach
        @else
            <x-filament::empty-state
                    icon="heroicon-o-bell-slash"
                    icon-color="gray"
                    icon-size="md"
                    :contained="false"
            >
                <x-slot name="heading">
                    {{ __($this->tab === 'all' ? 'cloudcake-themes::notifications.empty_all' : 'cloudcake-themes::notifications.empty_unread') }}
                </x-slot>
                <x-slot name="description">{{ __('cloudcake-themes::notifications.description') }}<br>{{ __('cloudcake-themes::notifications.subtext') }}</x-slot>
            </x-filament::empty-state>
        @endif

        @if ($broadcastChannel = $this->getBroadcastChannel())
            @script
            <script>
                window.addEventListener('EchoLoaded', () => {
                    window.Echo.private(@js($broadcastChannel)).listen(
                        '.database-notifications.sent',
                        () => {
                            setTimeout(
                                () => $wire.call('$refresh'),
                                500,
                            )
                        },
                    )
                })

                if (window.Echo) {
                    window.dispatchEvent(new CustomEvent('EchoLoaded'))
                }
            </script>
            @endscript
        @endif

        @if ($isPaginated)
            <x-slot name="footer">
                <x-filament::pagination :paginator="$notifications" />
            </x-slot>
        @endif
    </x-filament::modal>

    <x-filament-actions::modals />
</div>
