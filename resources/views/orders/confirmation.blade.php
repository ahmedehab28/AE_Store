<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/orders/confirmation.css')}}" />

    <title>Purchase Successful!</title>
</head>
<body>
    @include('layouts.header')
    <div class="home-body">
        <div class="container order-details-contianer mt-5 mb-5">
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
                <div class="card-footer">
                    <div class="row">
                        <div class="col-md text-center">
                            <a href="{{route('orders.show', $order->id)}}" class="btn btn-primary btn-block mb-1 order-details-button">ORDER DETAILS</a>
                        </div>
                        <div class="col-md text-center">
                            <a href="{{route('orders.index')}}" class="btn btn-success btn-block order-details-button">PURCHASE HISTORY</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('layouts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

</body>
</html>
