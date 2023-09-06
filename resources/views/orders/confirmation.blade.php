<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/auth/auth.css')}}" />

    <title>Purchase Successful!</title>
</head>
<body>
    @include('layouts.header')
        <div class="container mt-5">
            <div class="card">
                <div class="card-header">
                    <h3>Order Purchased Successfully</h3>
                </div>
                <div class="card-body">
                    <h4>Order Details:</h4>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Order ID: {{ $order->id }}</li>
                        <li class="list-group-item">Product: {{ $order->product->name }}</li>
                        <li class="list-group-item">Quantity: {{ $order->quantity }}</li>
                    </ul>
                </div>
                <div class="card-footer text-muted">
                    Thanks for shopping with us!
                </div>
            </div>
        </div>
        <div class="row">
            <a href="{{route('orders.show', $order->id)}}"><input class="card-button add-to-cart" type="submit" value="ORDER DETAILS"></a>
            <a href="{{route('orders.index')}}"><input class="card-button add-to-cart" type="submit" value="PURCHASE HISTORY"></a>
        </div>

    @include('layouts.footer')
    <script src="{{ asset('js/auth/loginValidation.js')}}"></script>
</body>
</html>
