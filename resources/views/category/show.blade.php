<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/TableStyle.css') }}" rel="stylesheet" type="text/css" >

    <title>{{$category->name}}</title>
</head>
<body>
    <h1>Category: {{$category->name}}</h1>
    @if ($category->products->count() > 0)
    <table>
        <thead>
            <th>Name</th>
            <th>Price</th>
            <th>Availability</th>
        </thead>
        <tbody>
            @foreach ($category->products as $product)
            <tr>
                <td>{{$product->name}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->availability}}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <h3>No products in this category yet!</h3>
    @endif

    <a href="{{route('category.index')}}"><button>Back</button></a>
</body>
</html>
