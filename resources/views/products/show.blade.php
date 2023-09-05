<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/TableStyle.css') }}" rel="stylesheet" type="text/css" >

    <title>{{ $product->name }}</title>
</head>
<body>
    <h1>Product Details</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Availability</th>
                <th>Category</th>
                <th>Picture</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{$product->name}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->availability}}</td>
                <td>{{$product->category->name}}</td>
                <td><img src="{{ asset('images/' . $product->picture) }}"></td>
            </tr>
        </tbody>
    </table>
    <a href="{{route('product.index')}}"><button>Back</button></a>
</body>
</html>
