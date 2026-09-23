@php
    use Cloudcake\Themes\AuthLayout;

    /** @var AuthLayout $layout */
    $hasStage = $layout->hasStage();
    $brandOnStage = $layout->movesBrandToStage();
@endphp

<div class="fi-theme-login" data-theme-login="{{ $layout->value }}">
    @if ($hasStage)
        <div
                class="fi-theme-login-stage"
                @if (! $brandOnStage)
                    aria-hidden="true"
                @endif
        >
            <div class="fi-theme-login-stage-inner">
                @if ($brandOnStage && filled(filament()->getBrandLogo()))
                    <x-filament-panels::logo class="fi-theme-login-stage-logo"/>
                @endif

                <p class="fi-theme-login-stage-name">{{ filament()->getBrandName() }}</p>

                @if (filled($tagline))
                    <p class="fi-theme-login-stage-tagline">{{ $tagline }}</p>
                @endif
            </div>
        </div>
    @endif
</div>