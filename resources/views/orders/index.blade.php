<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/TableStyle.css') }}" rel="stylesheet" type="text/css" >

    <title>Orders</title>
</head>
<body>
    <a href="{{route('product.index')}}"><button>Products</button></a>
    <a href="{{route('category.index')}}"><button>Categories</button></a>
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Product</th>
                <th>Price</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ $order->user->name }}</td>
                    <td>{{ $order->product->name }}</td>
                    <td>{{ $order->price }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>
