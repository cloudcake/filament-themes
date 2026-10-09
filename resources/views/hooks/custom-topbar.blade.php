@php
    $databaseNotificationsEnabled = $panel->hasDatabaseNotifications();
@endphp
<div class="fi-theme-topbar-wrp">
    <div class="fi-theme-topbar-ctn w-full">
        <div class="fi-theme-toolbar py-1 w-full">
            <div class="flex items-center w-full justify-end">
                <div x-data="{ open: false }"
                    x-on:toggle-search="
                                        open = ! open
                                        if (open) {
                                            $nextTick(() => $el.querySelector('.fi-global-search-field input')?.focus())
                                        }
                                    "
                    x-on:focusout="
                                        $nextTick(() => {
                                            if (! $el.contains(document.activeElement)) {
                                                open = false
                                            }
                                        })
                                    "
                    x-on:keydown.window.prevent.cmd.k="$dispatch('toggle-search')"
                    x-on:keydown.window.prevent.ctrl.f="$dispatch('toggle-search')"
                    x-on:keydown.escape.window="open = false"
                    class="flex items-center"
                >
                    <div
                            x-cloak
                            x-bind:class="{ 'open': open }"
                            class="fi-toolbar-search-ctn"
                    >
                        @livewire(\Filament\Livewire\GlobalSearch::class)
                    </div>

                    <x-filament::icon-button
                            x-on:click="$dispatch('toggle-search')"
                            type="button"
                            color="gray"
                            icon="heroicon-o-magnifying-glass"
                            :label="__('filament-panels::global-search.field.label')"
                    />
                </div>

                @if($databaseNotificationsEnabled)
                @php
                    $unread = (int) filament()->auth()->user()?->unreadNotifications->count();
                @endphp
                <x-filament::icon-button
                        x-data="{}"
                        x-on:click="$dispatch('open-modal', { id: 'database-notifications' })"
                        type="button"
                        color="gray"
                        icon="heroicon-o-bell"
                        icon-alias="panels::topbar.open-database-notifications-button"
                        :badge="$unread ?: null"
                        badge-color="primary"
                        :label="__('filament-panels::layout.actions.open_database_notifications.label')"
                />
                @endif

                @if ($panel->hasDarkMode() && !$panel->hasDarkModeForced())
                <div x-data="{
                    theme: null,
                    init() {
                        this.theme = localStorage.getItem('theme') || @js(filament()->getDefaultThemeMode()->value)

                        if (this.theme === 'system') {
                            this.theme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light'
                        }
                    },
                    toggle() {
                        this.theme = this.theme === 'dark' ? 'light' : 'dark'
                        localStorage.setItem('theme', this.theme)
                        $dispatch('theme-changed', this.theme)
                    },
                }"
                >
                    <x-filament::icon-button
                            x-cloak
                            x-show="theme !== 'dark'"
                            x-on:click="toggle()"
                            type="button"
                            color="gray"
                            icon="heroicon-o-moon"
                            label="Switch to dark mode"
                    />

                    <x-filament::icon-button
                            x-cloak
                            x-show="theme === 'dark'"
                            x-on:click="toggle()"
                            type="button"
                            color="gray"
                            icon="heroicon-o-sun"
                            label="Switch to light mode"
                    />
                </div>
                @endif
            </div>
        </div>
        @if(!blank($advertisement))
            <div class="fi-announcement-banner w-full px-4 py-2">
                {!! $advertisement !!}
            </div>
        @endif
    </div>
</div>