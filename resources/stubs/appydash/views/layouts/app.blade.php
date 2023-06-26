<!DOCTYPE html>
<html   lang="{{ str_replace('_', '-', app()->getLocale()) }}" 
        x-data="{ darkMode: localStorage.getItem('dark') === 'true'}"
		x-init="$watch('darkMode', val => localStorage.setItem('dark', val))"
		x-bind:class="{ 'dark': darkMode }"
        >
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <style>
             x-cloak{
                display:none;
             }
        </style>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
    <div class="flex bg-white dark:bg-gray-900" x-data="initComponent()" x-init="checkIsMobile()" x-on:resize.window.debounce.200="checkIsMobile">
        <x-sidebar/>
        <div
               x-data="{}"
               :class="{
                    'lg:pl-[var(--collapsed-sidebar-width)] rtl:lg:pr-[var(--collapsed-sidebar-width)]': ! isSidebarOpen,
                    'lg:pl-[var(--sidebar-width)] rtl:lg:pr-[var(--sidebar-width)]': isSidebarOpen,
                }"
               :style="'display: flex'" 
                class="filament-main flex-col gap-y-6 w-screen flex-1 rtl:lg:pl-0 hidden h-full transition-all">
                <x-admin-navigation/>
                <main class="px-4 pt-4">
                {{ $slot }}
                </main>
            <x-footer />
        </div>
    </div>
    

        <script>
            function initComponent() {
                return {
                    isSidebarOpen: true,
                    isMobile: false,
                    checkIsMobile: function() {
                        this.isMobile = (window.outerWidth < 480) && this.isTouchEnabled()
                        this.isSidebarOpen = !this.isMobile
                    },
                    isTouchEnabled: function() {
                        return ('ontouchstart' in window) ||
                        (navigator.maxTouchPoints > 0) ||
                        (navigator.msMaxTouchPoints > 0);
                    },
                }
            }
        </script>
    @stack('scripts')
    
    </body>
</html>
