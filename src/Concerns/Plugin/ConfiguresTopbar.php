<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Closure;
use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

trait ConfiguresTopbar
{
    protected string|null|HtmlString|Closure $toolbarAdvertisement = null;

    public function toolbarAdvertisement(string|null|HtmlString|Closure $content): static
    {
        $this->toolbarAdvertisement = $content;

        return $this;
    }

    protected function applyTopbar(Panel $panel): static
    {
        $render = str('');

        if (!$panel->hasTopbar()) {
            $render = $render->append(<<<'BLADE'
                  <div
                        x-data="{ open: false }"
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
           BLADE
            );

            $render = $render->append(<<<'BLADE'
                
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
                BLADE
            );

            if ($panel->hasDarkMode() && !$panel->hasDarkModeForced()) {
                $render = $render->append(<<<'BLADE'
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
                BLADE
                );
            }

            $render = $render->wrap('<div class="flex items-center w-full justify-end">', '</div>');
            $render = $render->wrap('<div class="fi-theme-toolbar w-full">', '</div>');
        }

        $advertisement = $panel->evaluate($this->toolbarAdvertisement);

        if (!blank($advertisement)) {

            $render = $render->append(
                str($advertisement)
                    ->wrap('<div class="fi-announcement-banner w-full px-4 py-2">', '</div>')
                    ->toString()
            );
        }

        if (!blank($render))
            $panel->renderHook(
                PanelsRenderHook::CONTENT_BEFORE,
                fn() => Blade::render(
                    $render
                        ->wrap('<div class="fi-theme-topbar-ctn w-full">', '</div>')
                        ->wrap('<div class="fi-theme-topbar-wrp backdrop-blur sticky top-0 left-0 right-0 z-10">', '</div>')
                        ->toString()
                ),
            );

        return $this;
    }
}