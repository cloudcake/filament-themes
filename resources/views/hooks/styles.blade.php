@php
/**
 * @var \Cloudcake\Themes\Roundness $roundness
 * @var \Cloudcake\Themes\Shadows $shadows
 * @var array|null $lightPanelColour
 * @var array|null $darkPanelColour
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
}

@if(is_array($lightPanelColour))
body {
{{--    @foreach($lightPanelColour as $shade => $colour)--}}
{{--    --gray-{{$shade}}: {{$colour}};--}}
{{--    @endforeach--}}

    --color-white: {{$lightPanelColour[600]}}
}
@endif

@if(is_array($darkPanelColour))
.dark:root {
    @foreach($darkPanelColour as $shade => $colour)
    --gray-{{$shade}}: {{$colour}};
    @endforeach
}
@endif
</style>