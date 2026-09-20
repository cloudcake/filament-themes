@php
/**
 * @var \Cloudcake\Themes\Roundness $roundness
 * @var \Cloudcake\Themes\Shadows $shadows
 * @var array|null $lightPanelColour
 * @var array|null $darkPanelColour
 * @var array<\Cloudcake\Themes\Bloom>|false|null $blooming
 */
@endphp
<style>
    body {
        @foreach($roundness->tokens() as $variable => $value)
        --{{$variable}}: {{$value}};
        --theme-{{$variable}}: {{$value}};
        @endforeach

        @foreach($shadows->tokens() as $variable => $value)
        --{{$variable}}: {{$value}};
        --theme-{{$variable}}: {{$value}};
        @endforeach

        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;

        @if(is_array($blooming) && !blank($blooming))
        background-image: @foreach($blooming as $index => $bloom)
            radial-gradient({{$bloom->spreadToken()}} {{ $bloom->positionToken() }}, {{ $bloom->lightColourToken() }}{{ $index < count($blooming)-1 ? ',' : ';' }}
        @endforeach
        @endif

        @if(!blank($lightBackgroundColour))
        --light-body-bg: {{$lightBackgroundColour}};
        @endif
    }

.dark body {
    @if(!blank($darkBackgroundColour))
    --dark-body-bg: {{$darkBackgroundColour}};
    @endif

    @if(is_array($blooming) && !blank($blooming))
        background-image: @foreach($blooming as $index => $bloom)
           radial-gradient({{$bloom->spreadToken()}} {{ $bloom->positionToken() }}, {{$bloom->darkColourToken() }}{{ $index < count($blooming)-1 ? ',' : ';' }}
        @endforeach
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