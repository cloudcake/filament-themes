@php
    use Cloudcake\Themes\Enums\Roundness;use Cloudcake\Themes\Enums\Shadows;use Cloudcake\Themes\Settings\Bloom;use Cloudcake\Themes\Settings\Styles;

    /**
    * @var array<Bloom>|false|null $blooming
    * @var Roundness $roundness
    * @var Shadows $shadows
    * @var array<int,string>|null $darkPrimaryColour
    * @var array<int,string>|null $lightPrimaryColour
    * @var array|null $darkBackgroundColour
    * @var array|null $lightBackgroundColour
    * @var bool $pageTransitions
    * @var float $pageTransitionDuration
    * @var float $pageTransitionOffset
    */
@endphp

<style>
    :root {
        {!! Styles::shadowTokens($shadows) !!}
        {!! Styles::roundnessTokens($roundness) !!}
        {!! Styles::transitionTokens($pageTransitionDuration, $pageTransitionOffset) !!}
        --theme-border-width: {{$borderWidth}}px;
    }

    body {
        {!! Styles::bloomTokens(blooming: $blooming, dark: false) !!}
        {!! Styles::shadeTokens($lightPrimaryColour, 'primary') !!}
        {!! Styles::backgroundTokens($lightBackgroundColour, $lightBackgroundShadeColour) !!}
    }

    .dark body {
        {!! Styles::bloomTokens(blooming: $blooming, dark: true) !!}
        {!! Styles::shadeTokens($darkPrimaryColour, 'primary') !!}
        {!! Styles::backgroundTokens($darkBackgroundColour, $darkBackgroundShadeColour) !!}
    }
</style>