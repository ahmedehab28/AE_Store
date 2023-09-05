<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/TableStyle.css') }}" rel="stylesheet" type="text/css" >

    <title>Categories</title>
</head>
<body>
    <a href="{{route('product.index')}}"><button>Products</button></a>
    <a href="{{route('orders.index')}}"><button>Orders</button></a>
    <table>
        <thead>
            <tr>
                <th>Category Name</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($categories as $category )
            <tr>
                <td>{{$category->name}}</td>
                <td><a href="{{route('category.show', $category)}}"><button>Show</button></a></td>
            </tr>
            @endforeach

        </tbody>
    </table>
</body>
</html>
