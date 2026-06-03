<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    {{-- Base Meta Tags --}}
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- PWA Meta Tags --}}
    <meta name="theme-color" content="#007bff">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <meta name="apple-mobile-web-app-title" content="Koperasi">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <link rel="apple-touch-icon" href="{{ asset('icons/icon-192x192.png') }}">

    {{-- Custom Meta Tags --}}
    @yield('meta_tags')

    {{-- Title --}}
    <title>
        @yield('title_prefix', config('adminlte.title_prefix', ''))
        @yield('title', config('adminlte.title', 'AdminLTE 3'))
        @yield('title_postfix', config('adminlte.title_postfix', ''))
    </title>

    {{-- IFrame Preloader Removal Workaround --}}
    <style type="text/css">
        body.iframe-mode .preloader {
            display: none !important;
        }
    </style>

    {{-- Custom stylesheets (pre AdminLTE) --}}
    @yield('adminlte_css_pre')

    {{-- Base Stylesheets (depends on Laravel asset bundling tool) --}}
    @if(config('adminlte.enabled_laravel_mix', false))
        <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_mix_css_path', 'css/app.css')) }}">
    @else
        @switch(config('adminlte.laravel_asset_bundling', false))
            @case('mix')
                <link rel="stylesheet" href="{{ mix(config('adminlte.laravel_css_path', 'css/app.css')) }}">
            @break

            @case('vite')
                @vite([config('adminlte.laravel_css_path', 'resources/css/app.css'), config('adminlte.laravel_js_path', 'resources/js/app.js')])
            @break

            @case('vite_js_only')
                @vite(config('adminlte.laravel_js_path', 'resources/js/app.js'))
            @break

            @default
                <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}">
                <link rel="stylesheet" href="{{ asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
                <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

                @if(config('adminlte.google_fonts.allowed', true))
                    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
                @endif
        @endswitch
    @endif

    {{-- Extra Configured Plugins Stylesheets --}}
    @include('adminlte::plugins', ['type' => 'css'])

    {{-- Livewire Styles --}}
    @if(config('adminlte.livewire'))
        @if(intval(app()->version()) >= 7)
            @livewireStyles
        @else
            <livewire:styles />
        @endif
    @endif

    {{-- Custom Stylesheets (post AdminLTE) --}}
    @yield('adminlte_css')

</head>

<body class="@yield('classes_body')" @yield('body_data')>

    {{-- Body Content --}}
    @yield('body')

    {{-- Base Scripts --}}
    @if(config('adminlte.enabled_laravel_mix', false))
        <script src="{{ mix(config('adminlte.laravel_mix_js_path', 'js/app.js')) }}"></script>
    @else
        @switch(config('adminlte.laravel_asset_bundling', false))
            @case('mix')
                <script src="{{ mix(config('adminlte.laravel_js_path', 'js/app.js')) }}"></script>
            @break

            @case('vite')
            @case('vite_js_only')
            @break

            @default
                <script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
                <script src="{{ asset('vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
                <script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
                <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
        @endswitch
    @endif

    {{-- Extra Configured Plugins Scripts --}}
    @include('adminlte::plugins', ['type' => 'js'])

    {{-- Livewire Script --}}
    @if(config('adminlte.livewire'))
        @if(intval(app()->version()) >= 7)
            @livewireScripts
        @else
            <livewire:scripts />
        @endif
    @endif

    {{-- Service Worker Registration --}}
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(reg) {
                    console.log('SW registered:', reg.scope);
                }).catch(function(err) {
                    console.log('SW registration failed:', err);
                });
            });
        }
    </script>

    {{-- PWA Install Prompt --}}
    <script>
        let deferredPrompt = null;
        if (window.matchMedia('(display-mode: standalone)').matches) {
            var btn = document.getElementById('pwa-install-btn');
            if (btn) btn.style.display = 'none';
        }
        window.addEventListener('beforeinstallprompt', function(e) {
            e.preventDefault();
            deferredPrompt = e;
            var btn = document.getElementById('pwa-install-btn');
            if (btn) btn.style.display = 'flex';
        });
        window.addEventListener('appinstalled', function() {
            deferredPrompt = null;
            var btn = document.getElementById('pwa-install-btn');
            if (btn) btn.style.display = 'none';
        });
        function installPWA() {
            if (!deferredPrompt) return;
            deferredPrompt.prompt();
            deferredPrompt.userChoice.then(function(choiceResult) {
                deferredPrompt = null;
                document.getElementById('pwa-install-btn').style.display = 'none';
            });
        }
    </script>

    {{-- PWA Install Floating Button --}}
    <button id="pwa-install-btn" onclick="installPWA()" style="display:none;position:fixed;bottom:20px;right:20px;z-index:9999;background:#007bff;color:#fff;border:none;border-radius:50px;padding:12px 20px;font-size:14px;cursor:pointer;box-shadow:0 4px 12px rgba(0,0,0,0.3);align-items:center;gap:8px;">
        <i class="fas fa-download"></i> Install App
    </button>

    {{-- Custom Scripts --}}
    @yield('adminlte_js')

</body>

</html>
