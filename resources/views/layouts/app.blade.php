<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tanzim L2</title>

        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        @yield('styles')
    </head>
    <body>
            <div>
                @yield('content')
            </div>
            
            <script src="{{ asset('js/jquery.min.js') }}"></script>
            <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
            <script src="{{ asset('js/app-functions.js') }}"></script>
            @yield('scripts')
    </body>
</html>
