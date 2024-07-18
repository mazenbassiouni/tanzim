<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Tanzim L2</title>
        <link href="{{ asset('img/tab-logo.png') }}" rel="icon">

        <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
        @yield('styles')
    </head>
    <body>
            @include('includes.navbar')
            <div class="container py-5">
                @yield('content')
            </div>
            
            @include('includes.modals')
            <script src="{{ asset('js/jquery.min.js') }}"></script>
            <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
            <script src="{{ asset('js/app-functions.js') }}"></script>
            <script>
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                })
            </script>
            @if (!request()->route()->named('show-mission') && !request()->route()->named('force') && !request()->route()->named('missions-settings') && !request()->route()->named('show-category'))
                @include('includes.new-mission-scripts')
            @endif
            @yield('scripts')
    </body>
</html>
