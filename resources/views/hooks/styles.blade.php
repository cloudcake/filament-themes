@php
use Cloudcake\Themes\Bloom;
use Cloudcake\Themes\Styles;
use Cloudcake\Themes\Roundness;
use Cloudcake\Themes\Shadows;

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
        {!! Styles::shadeTokens($lightPrimaryColour, 'primary') !!}
        {!! Styles::backgroundTokens($lightBackgroundColour, $lightBackgroundShadeColour) !!}
        {!! Styles::transitionTokens($pageTransitionDuration, $pageTransitionOffset) !!}
    }
    body {
        {!! Styles::bloomTokens(blooming: $blooming, dark: false) !!}
    }
    .dark body {
        {!! Styles::bloomTokens(blooming: $blooming, dark: true) !!}
        {!! Styles::shadeTokens($darkPrimaryColour, 'primary') !!}
        {!! Styles::backgroundTokens($darkBackgroundColour, $darkBackgroundShadeColour) !!}
    }
</style>