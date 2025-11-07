<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'HR Portal') }}</title>

        <!-- Theme CSS -->
        <link rel="stylesheet" href="{{ asset('new_theme/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('new_theme/dist/css/AdminLTE.min.css') }}">
        <link rel="stylesheet" href="{{ asset('new_theme/dist/css/skins/_all-skins.min.css') }}">
        <link rel="stylesheet" href="{{ asset('new_theme/css/macos.css') }}">
        <link rel="stylesheet" href="{{ asset('new_theme/css/visby-fonts.css') }}">

        <!-- Breeze/Vite assets -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="macos-theme" style="min-height:100vh; background-image: url('{{ asset('new_theme/images/iso1.jpg') }}'); background-position:center; background-repeat:no-repeat; background-size:100% 100%;">
        <div class="container" style="min-height:100vh; display:flex; align-items:center; justify-content:center;">
            <div class="" style="width:100%; max-width: 420px;">
                <div class="box box-solid" style="background: rgba(255,255,255,0.9); border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.15);">
                    <div class="box-header with-border" style="border-radius: 12px 12px 0 0; background: #f8f8f8;">
                        <h3 class="box-title" style="font-weight:700; color:#111;">{{ config('app.name', 'HR Portal') }}</h3>
                    </div>
                    <div class="box-body" style="padding: 20px;">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Theme JS (optional minimal) -->
        <script src="{{ asset('new_theme/bower_components/jquery/dist/jquery.min.js') }}"></script>
        <script src="{{ asset('new_theme/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    </body>
    </html>
