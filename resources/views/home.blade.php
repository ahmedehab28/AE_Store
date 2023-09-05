<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{asset('css/home.css')}}">

        <title>Home</title>
    </head>
    <body>
        @include('layouts.header')
        <div class="home-body">
            <h1>HOME SWEET HOME</h1>

        </div>
        @include('layouts.footer')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    </body>
</html>
