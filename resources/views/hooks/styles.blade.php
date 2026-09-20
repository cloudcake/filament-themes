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

        background-color: var(--theme-canvas);
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: 100% 100%;

        @if(is_array($blooming) && !blank($blooming))
        background-image: @foreach($blooming as $index => $bloom)
            radial-gradient({{$bloom->spreadToken()}} {{ $bloom->positionToken() }}, {{ $bloom->lightColourToken() }}{{ $index < count($blooming)-1 ? ',' : ';' }}
        @endforeach
        @endif

        @if(is_array($lightBackgroundColour))
            --light-body-bg: {{$lightBackgroundColour[600]}}
        @endif

        @if(is_array($lightPanelColour))
        --color-white: {{$lightPanelColour[600]}}
        @endif
    }

.dark body {
    @if(is_array($darkPanelColour))
        @foreach($darkPanelColour as $shade => $colour)
        --gray-{{$shade}}: {{$colour}};
        @endforeach
    @endif

    @if(is_array($blooming) && !blank($blooming))
        background-image: @foreach($blooming as $index => $bloom)
           radial-gradient({{$bloom->spreadToken()}} {{ $bloom->positionToken() }}, {{$bloom->darkColourToken() }}{{ $index < count($blooming)-1 ? ',' : ';' }}
        @endforeach
    @endif

    @if(is_array($darkBackgroundColour))
        --dark-body-bg: {{$darkBackgroundColour[600]}};
    @else

    @endif
</style>