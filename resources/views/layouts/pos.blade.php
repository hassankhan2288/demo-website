<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width,initial-scale=1" />
<meta http-equiv="X-UA-Compatible" content="ie=edge" />
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<title>{{ config('app.name', 'Cater Choice') }}</title>
<head>
    @yield('styles')
</head>

<body class="bg-blue-gray-50" x-data="initApp()" x-init="initDatabase()">
    @yield('content')

    @include('pos.includes.foot')

    @yield('scripts')
    
</body>
</html>
