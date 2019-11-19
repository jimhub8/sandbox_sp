<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="user" content="Auth::user()">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link rel="icon" href="/storage/logo.png">

    <!-- Fonts -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet">
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
     <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <!-- Styles -->

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {{--  <link href="{{ asset('css/main.css') }}" rel="stylesheet">  --}}
    <link href="{{ asset('css/vueDash.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <main class="py-4">

            @yield('content')
        </main>
    </div>

<script src="{{ asset('vuetify/js/vuetify.js') }}"></script>
</body>
</html>
