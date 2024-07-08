<!DOCTYPE html>
{{-- <html lang="{{ str_replace('_', '-', app()->getLocale()) }}"> --}}
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' | GC7' : config('app.name') }}</title>

    @vite(['resources/css/app.css', 'resources/css/style_gc7.css', 'resources/js/app.js'])

    @yield('styles')
</head>

<body class="min-h-screen font-sans antialiased bg-base-200/50 dark:bg-[#1c232b]">

    <div class="flex">

        <livewire:navigation.gc7.aside-menu />

        <x-main full-width>
            <x-slot:content>
                {{ $slot }}
            </x-slot:content>
        </x-main>

    </div>


    {{-- FOOTER --}}
    {{-- <div class="h-[300px] relative clear-both"> --}}
    <div class="h-[70px]">
        <hr style="color:red"><br>
        <livewire:navigation.footer />
        <br>
    </div>

    {{--  TOAST area --}}
    <x-toast />

    @yield('scripts')

</body>

</html>
