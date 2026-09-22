@php
use \Filament\Support\Colors\Color;

/**
 * @var \Cloudcake\Themes\Roundness $roundness
 * @var \Cloudcake\Themes\Shadows $shadows
 * @var array|null $lightPanelColour
 * @var array|null $darkPanelColour
 * @var array<\Cloudcake\Themes\Bloom>|false|null $blooming
 * @var array<int,string>|null $darkPrimaryColour
 * @var array<int,string>|null $lightPrimaryColour
 */
@endphp
<style>
body {
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: 100% 100%;

    @if(!blank($lightPrimaryColour))
    @foreach($lightPrimaryColour as $shade => $value)
    --primary-{{$shade}}: {{$value}};
    @endforeach
    @endif

    @if(!blank($lightBackgroundColour))
    background-color: {{ $lightBackgroundColourShaded  === true ? "color-mix(in oklab, $lightBackgroundColour 50%, white 50%)" : $lightBackgroundColour }};
    @endif

    @foreach($roundness->tokens() as $variable => $value)
    --{{$variable}}: {{$value}};
    --theme-{{$variable}}: {{$value}};
    @endforeach

    @foreach($shadows->tokens() as $variable => $value)
    --{{$variable}}: {{$value}};
    --theme-{{$variable}}: {{$value}};
    @endforeach

    @if(is_array($blooming) && !blank($blooming))
    background-image: @foreach($blooming as $index => $bloom)
        radial-gradient({{$bloom->spreadToken()}} {{ $bloom->positionToken() }}, {{ $bloom->lightColourToken() }}{{ $index < count($blooming)-1 ? ',' : ';' }}
    @endforeach
    @endif

    @if($rails)
    .fi-wi-stats-overview-stat,
    .fi-ta-main,
    .fi-main-ctn,
    .fi-section:not(:has(.fi-wi-stats-overview-stat)):not(.fi-aside):not(.fi-section-not-contained),
    .fi-section:not(.fi-section-not-contained).fi-aside>.fi-section-content-ctn,
    .fi-section:not(.fi-section-not-contained).fi-aside>.fi-section-content-ctn:where(.dark,.dark *) {
        --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
        border: 1px solid color-mix(in oklab, var(--primary-200) 80%, transparent) !important;
        outline-offset: -8px;
        outline-width: 1px;
        outline-color: color-mix(in oklab, var(--primary-200) 50%, transparent) !important;
        --tw-outline-style: double;
        outline-style: double;
    }
    @endif
}

.dark body {
    background-repeat: no-repeat;
    background-attachment: fixed;
    background-size: 100% 100%;

    @if(!blank($darkPrimaryColour))
    @foreach($darkPrimaryColour as $shade => $value)
    --primary-{{$shade}}: {{$value}};
    @endforeach
    @endif

    @if(!blank($darkBackgroundColour))
    @for($i = 5; $i < 10; $i++)
        --gray-{{$i*100}}: color-mix(in oklab, {{ $darkBackgroundColour }} 80%, color-mix(in oklab, var(--primary-950) 85%, white {{100-($i*12)}}%) {{$i*10}}%);
    @endfor
    --gray-900: color-mix(in oklab, {{ $darkBackgroundColour }} 80%, color-mix(in oklab, var(--primary-950) 85%, white 15%) 20%);
    --gray-950: {{ $darkBackgroundColour }};

    background-color: {{ $darkBackgroundColour }};
    @endif

    @if(is_array($blooming) && !blank($blooming))
        background-image:
        @foreach($blooming as $index => $bloom)
            radial-gradient({{$bloom->spreadToken()}} {{ $bloom->positionToken() }}, {{$bloom->darkColourToken() }} {{ $index < count($blooming)-1 ? ',' : '' }}
        @endforeach
        @if ($darkBackgroundColourShaded === true)
            , radial-gradient(100% 100% at center center, color-mix(in oklab, {{$darkBackgroundColour}} 90%, var(--primary-950)) 90%, black 100%);
        @else
            ;
        @endif
    @endif

    @if($rails)
    .fi-wi-stats-overview-stat,
    .fi-ta-main,
    .fi-main-ctn,
    .fi-section:not(:has(.fi-wi-stats-overview-stat)):not(.fi-aside):not(.fi-section-not-contained),
    .fi-section:not(.fi-section-not-contained).fi-aside>.fi-section-content-ctn,
    .fi-section:not(.fi-section-not-contained).fi-aside>.fi-section-content-ctn:where(.dark,.dark *) {
        --tw-ring-offset-shadow: var(--tw-ring-inset) 0 0 0 var(--tw-ring-offset-width) var(--tw-ring-offset-color);
        border: 1px solid color-mix(in oklab, var(--primary-800) 40%, transparent) !important;
        outline-offset: -8px;
        outline-width: 1px;
        outline-color: color-mix(in oklab, var(--primary-800) 40%, transparent) !important;
        --tw-outline-style: double;
        outline-style: double;
    }
    @endif
}

@if($pageTransitions)
.fi-body .fi-main>.fi-page,
.fi-body .fi-simple-main {
    animation: theme-rise {{$pageTransitionDuration}}s;
}

@keyframes theme-rise {
    from {
        opacity: 0;
        transform: translateY({{ doubleval($pageTransitionOffset) }}rem);
    }

    to {
        opacity: 1;
        transform: translateY(0);
    }
}
@endif
</style>