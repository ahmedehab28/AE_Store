<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
        <link rel="stylesheet" href="{{ asset('css/index.css') }}">
        <link rel="stylesheet" href="{{ asset('css/products/create.css') }}">
        <script src="{{ asset('js/reload.js') }}"></script>

        <title>Categories</title>
    </head>

    <body>
        @include('layouts.header')
        <div class="main-body-container">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>

                <div class="container">
                    @foreach ($users as $user)
                        <h2>{{ $user->name }}'s Orders</h2>
                        @foreach ($user->orders as $order)
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Order #{{ $order->id }}</h5>
                                    <!-- Add more order details here -->
                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-primary">Show Details</a>
                                </div>
                            </div>
                        @endforeach
                    @endforeach
                </div>


            @endif
        </div>
        @include('layouts.footer')
    </body>

</html>
