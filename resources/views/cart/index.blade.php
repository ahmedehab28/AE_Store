<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <script src="{{ asset('js/reload.js') }}"></script>

    <title>Your Cart</title>
</head>

<body>
    @include('layouts.header')
    <div class="main-body-container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('errors'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('errors')->first('out_of_stock') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h1><i class="fas fa-shopping-cart"></i> Your Cart</h1>
        @if ($cartItems->isEmpty())
            <h2>No items added yet!</h2>
        @else
            <div class="container">
                <div class="row">
                    @foreach ($cartItems as $item)
                        <div class="col-12 my-2">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h5 class="card-title">{{ $item->name }}</h5>
                                            <p>Price: {{ $item->price }}</p>
                                            <p>Quantity: {{ $item->quantity }}</p>
                                        </div>
                                        <div class="d-flex flex-column flex-md-row">
                                            <form action="{{ route('cart.removeOne', $item->id) }}" method="POST"
                                                class="me-md-2 mb-2 mb-md-0">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" value="Remove One"
                                                    class="btn btn-warning btn-fixed">
                                            </form>
                                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" value="Remove from Cart"
                                                    class="btn btn-danger btn-fixed">
                                            </form>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="container">
                <div class="row">
                    <div class="col-12 text-center">
                        <h1>Done Shopping?</h1>
                        <form action="{{ route('cart.buy') }}" method="POST">
                            @csrf
                            <input type="submit" value="Checkout" class="btn btn-success btn-fixed">
                        </form>
                    </div>
                </div>
            </div>

        @endif


    </div>

    @include('layouts.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
