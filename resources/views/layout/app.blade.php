<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link rel="stylesheet" href="{{asset('/css/styles.css')}}">
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            <div class="content">
                @yield('home')
            </div>
        </div>
    </body>
    <script src="{{asset('/js/main.js')}}"></script>
</html>
