<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">

    <link href="{{ asset('css/orders/index.css') }}" rel="stylesheet" type="text/css" >

    <title>Purchase History</title>
</head>
<body>
    @include('layouts.header')
    <div class="home-body">
        <h1>Purchase History</h1>
        <div class="container">
            <div class="row">
                @foreach ($orders as $order)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-12">
                    <a href="{{route('orders.show',$order->id)}}">
                        <div class="card mb-3">
                            <div class="card-header">
                                Ordered on: {{ $order->created_at }}
                            </div>
                            <div class="card-body">
                                <h5 class="card-title">{{ $order->product->name }}</h5>
                                <h6 class="card-title">Category: {{ $order->product->category->name }}</h6>
                                <p class="card-text">Price: {{ $order->price }}</p>
                                <p class="card-text">Quantity: {{ $order->quantity }}</p>
                                <p class="card-text">Total: {{ $order->total }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach

            </div>
        </div>
    </div>

    @include('layouts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

</body>
</html>
