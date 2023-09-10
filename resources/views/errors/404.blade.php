<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <script src="{{ asset('js/reload.js') }}"></script>

    <style>
        .error {
            max-width: 50%;
            margin: auto;
            text-align: center;
        }
        .error img{
            max-width: 80%;
        }
    </style>
    <title>404 - Page Not Found</title>
</head>

<body>
    <div class="error">
        <img class="rounded mx-auto d-block" src="{{ asset('images/logo.png') }}" alt="AE Logo">
        <h1>Sorry, page not found</h1>
        <h3>Go back to home page? <a href="{{ route('home') }}">Home</a></h3>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
    </div>

</body>

</html>
