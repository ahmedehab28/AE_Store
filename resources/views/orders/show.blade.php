<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Order {{$order->id}}</title>
</head>
<body>
    <h1>Order Details</h1>
    <ul>
        <li>Order ID: {{ $order->id }}</li>
        <li>User: {{ $order->user->name }}</li>
        <li>Product: {{ $order->product->name }}</li>
        <li>Quantity: {{$order->quantity}}</li>
        <li>Price: {{ $order->product->price*$order->quantity}}</li>
        <li>Created at: {{ $order->created_at }}</li>
        <li>Updated at: {{ $order->updated_at }}</li>
    </ul>
</body>
</html>
