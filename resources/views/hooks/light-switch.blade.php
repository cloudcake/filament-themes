@if (filament()->hasDarkMode() && (! filament()->hasDarkModeForced()))
    <div @class(['fixed w-full flex p-4 z-40 auth-theme-switcher top-0 justify-end'])>
        <div class="fi-light-switch">
            <div
                    x-data="{
                    theme: null,

                    init: function () {
                        this.theme = localStorage.getItem('theme') || @js(filament()->getDefaultThemeMode()->value)

                        $dispatch('theme-changed', theme)

                        $watch('theme', (theme) => {
                            $dispatch('theme-changed', theme)
                        })
                    },
                }"
                    class="fi-theme-switcher grid grid-flow-col gap-x-1"
            >
                <button
                        aria-label="Dark Mode Switch"
                        type="button"
                        x-bind:class="
                            theme === 'dark'
                                ? 'text-primary-500'
                                : 'text-gray-400'
                        "
                                            x-on:click="(theme = 'dark')"
                                            x-tooltip="{
                           content: 'Dark Mode',
                            theme: $store.theme,
                        }"
                        class="flex justify-center rounded-lg p-2 outline-none transition duration-75 hover:bg-gray-50 dark:hover:bg-white/5">
                    <x-filament::icon
                            :alias="'panels::theme-switcher.dark-button'"
                            icon="tabler-moon"
                            class="h-5 w-5"
                    />
                </button>

                <button
                        aria-label="Light Mode Switch"
                        type="button"
                        x-bind:class="
                            theme === 'light'
                                ? 'text-primary-500'
                                : 'text-gray-400'
                        "
                        x-on:click="(theme = 'light')"
                        x-tooltip="{
                            content: 'Light Mode',
                            theme: $store.theme,
                        }"
                        class="flex justify-center rounded-lg p-2 outline-none transition duration-75 hover:bg-gray-50 dark:hover:bg-white/5">
                    <x-filament::icon
                            :alias="'panels::theme-switcher.light-button'"
                            icon="tabler-sun"
                            class="h-5 w-5"
                    />
                </button>
            </div>
        </div>
    </div>
@endif