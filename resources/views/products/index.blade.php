<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{ asset('css/TableStyle.css') }}" rel="stylesheet" type="text/css" >

    <title>Products</title>
</head>
<body>
    <a href="{{route('category.index')}}"><button>Categories</button></a>
    @can('manage-products')
    <a href="{{route('product.create')}}"><button>Add Product</button></a>
    <a href="{{route('orders.index')}}"><button>Orders</button></a>
    @endcan

    @if($products->isEmpty())
        <h1>No products yet!</h1>
    @else
        <h1>Products</h1>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>price</th>
                    <th>availablity</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($products as $product )
                <tr>
                    <td>{{$product->name}}</td>
                    <td>{{$product->price}}</td>
                    <td>{{$product->availability}}</td>
                    <td>
                        <a href="/products/{{ $product->id }}"><button>Show</button></a>
                        <form action="{{route('product.destroy',$product->id)}}" method="post">
                            @method('DELETE')
                            @csrf
                            <button type="submit">Delete</button>
                        </form>
                        <form action="{{route('product.update',$product->id)}}" method="get">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>
    @endif

</body>
</html>
