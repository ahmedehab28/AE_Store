<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link href="{{ asset('css/orders/index.css') }}" rel="stylesheet" type="text/css" >
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

    <script src="{{asset('js/reload.js')}}"></script>

    <title>Purchase History</title>
</head>
<body>
    @include('layouts.header')
    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="main-body-container">
        @if ($orders->isEmpty())
            <h1>No purchases yet!</h1>
        @else
        <h1>Purchase History</h1>
        <div class="container">
            <div class="row">
                @foreach ($orders as $order)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">

                    <a href="{{route('orders.show',$order->id)}}">
                        <div class="card mb-3">

                            <div class="card-header">
                                Ordered on: {{ $order->created_at->format('D, M j, Y \\a\\t g:i A') }}
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">{{ $order->product->name }}</h5>
                                <h6 class="card-subtitle mb-2"><span class="card-attribute">Category:</span> {{ $order->product->category->name }}</h6>
                                <p class="card-text"><span class="card-attribute">Quantity:</span> {{ $order->quantity }}</p>
                                <p class="card-text"><span class="card-attribute">Product Price:</span> {{ $order->product->price }}</p>
                                <p class="card-text"><span class="card-attribute">Total Price:</span> {{ $order->product->price * $order->quantity }}</p>
                            </div>

                        </div>
                    </a>

                </div>
                @endforeach

            </div>
        </div>
        @endif
    </div>

    @include('layouts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

</body>
</html>
