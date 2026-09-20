@php
    /**
     * @var \Cloudcake\Themes\Roundness $roundness
     */
@endphp
<style>
    body {
        @foreach($roundness->tokens() as $variable => $value)
            --{{$variable}}: {{$value}};

            --theme-{{$variable}}: {{$value}};
        @endforeach
    }
</style>