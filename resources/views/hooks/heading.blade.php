@if ($icon = $this::getNavigationIcon() ?? false)
    <span class="inline-flex items-center align-top ml-1 mr-2">
        <x-filament::icon
                :icon="$icon"
                class="h-8 w-8 text-gray-500 dark:text-gray-700"
        />
    </span>
@endif