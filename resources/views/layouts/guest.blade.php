<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HR Portal') }}</title>

        <!-- Theme CSS (optional) -->
        <link rel="stylesheet" href="{{ asset('new_theme/css/macos.css') }}">
        <link rel="stylesheet" href="{{ asset('new_theme/css/visby-fonts.css') }}">

        <!-- Breeze/Vite assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="macos-theme" style="min-height:100vh; background: linear-gradient(145deg,#fff7f4,#fff);">
        {{ $slot }}

        <!-- Lottie Player -->
        <script src="https://unpkg.com/@lottiefiles/lottie-player@latest/dist/lottie-player.js"></script>
        
        <!-- Optional JS -->
        <script src="{{ asset('new_theme/bower_components/jquery/dist/jquery.min.js') }}"></script>
    </body>
    </html>
