<?php

namespace Cloudcake\Themes\Concerns\Plugin;

use Filament\Panel;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

trait ConfiguresAnimations
{
    protected function applyAnimations(Panel $panel): static
    {
//        $panel->renderHook(
//            PanelsRenderHook::BODY_START,
//            fn() => new HtmlString(<<<'JS'
//                <script src="https://cdn.jsdelivr.net/npm/animejs/dist/bundles/anime.umd.min.js"></script>
//                <script>
//                const { animate, stagger } = anime;
//
//                document.addEventListener('DOMContentLoaded', () => {
//                    animate('.fi-sidebar-item', {
//                      x: [-30, 0],
//                      opacity: [0, 1],
//                      scale: [0.55, 1],
//                      delay: stagger(80),
//                      duration: 1200,
//                      ease: 'outExpo',
//                    });
//
//                    animate('.fi-breadcrumbs-item,.fi-header>div', {
//                      x: [-20, 0],
//                      opacity: [0, 1],
//                      scale: [0.75, 1],
//                      delay: stagger(100),
//                      duration: 1200,
//                      ease: 'outExpo',
//                    });
//
//                    animate('section,.fi-section>.fi-section-content-ctn', {
//                      y: [60, 0],
//                      opacity: [0, 1],
//                      scale: [0.75, 1],
//                      delay: stagger(50),
//                      duration: 200,
//                      ease: 'outExpo',
//                    });
//                });
//                </script>
//                JS
//            )
//        );

        return $this;
    }
}
