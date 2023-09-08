<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/orders/details.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <script src="{{ asset('js/reload.js') }}"></script>

    <title>Order {{ $order->id }}</title>
</head>

<body>
    @include('layouts.header')
    <div class="main-body-container">
        <div class="container order-details-contianer mt-5 mb-5">
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card p-3">
                        <h4>Order Details:</h4>
                        <table class="table">
                            <tr>
                                <td class="card-attribute">Order ID:</td>
                                <td>{{ $order->id }}</td>
                            </tr>
                            <tr>
                                <td class="card-attribute">Product:</td>
                                <td>{{ $order->product->name }}</td>
                            </tr>
                            <tr>
                                <td class="card-attribute">Category:</td>
                                <td>{{ $order->product->category->name }}</td>
                            </tr>
                            <tr>
                                <td class="card-attribute">Quantity:</td>
                                <td>{{ $order->quantity }}</td>
                            </tr>
                            <tr>
                                <td class="card-attribute">Product Price:</td>
                                <td>{{ $order->product->price }}</td>
                            </tr>
                            <tr>
                                <td class="card-attribute">Total Price:</td>
                                <td>{{ $order->quantity * $order->product->price }}</td>
                            </tr>
                            <tr>
                                <td class="card-attribute">Ordered On:</td>
                                <td>{{ $order->created_at->format('D, M j, Y \\a\\t g:i A') }}</td>
                            </tr>
                        </table>

                        <div class="card-footer">
                            <div class="row d-flex">
                                <div class="col-md text-center">
                                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST"
                                        onsubmit="return confirm('Are you sure you want to continue with the refund operation?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="btn btn-block mb-1 order-details-button refund-button">REFUND</button>
                                    </form>

                                </div>
                                <div class="col-md text-center">
                                    <a href="{{ route('orders.index') }}"
                                        class="btn btn-success btn-block order-details-button">PURCHASE HISTORY</a>
                                </div>
                            </div>

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
