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
    body {
        {!! Styles::bloomTokens(blooming: $blooming, dark: false) !!}
        {!! Styles::roundnessTokens($roundness) !!}
        {!! Styles::shadowTokens($shadows) !!}
        {!! Styles::shadeTokens($lightPrimaryColour, 'primary') !!}
        {!! Styles::backgroundTokens($lightBackgroundColour, $lightBackgroundShadeColour) !!}
    }
    .dark body {
        {!! Styles::bloomTokens(blooming: $blooming, dark: true) !!}
        {!! Styles::shadeTokens($darkPrimaryColour, 'primary') !!}
        {!! Styles::backgroundTokens($darkBackgroundColour, $darkBackgroundShadeColour) !!}
    }
    {!! Styles::pageTransitions($pageTransitions, $pageTransitionDuration, $pageTransitionOffset) !!}
</style>