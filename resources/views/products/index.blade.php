<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link href="{{ asset('css/products/product-card.css') }}" rel="stylesheet" type="text/css">

    <title>Products</title>
</head>

<body>
    @include('layouts.header')
    <div class="main-product-index">
        <a href="{{ route('category.index') }}"><button>Categories</button></a>
        @can('manage-products')
            <a href="{{ route('product.create') }}"><button>Add Product</button></a>
            <a href="{{ route('orders.index') }}"><button>Orders</button></a>
        @endcan

        @if ($products->isEmpty())
            <h1>No products Found!</h1>
        @else
        <h1>Products</h1>
        <div class="row">
            @foreach ($products as $product)
                <div class="col-sm-4">
                    <div class="card">
                        @if($product->picture)
                        <img src="{{ $product->picture }}" class="card-img-top" alt="{{ $product->name }}">
                        @else
                        <img src="{{asset('images/header-logo.png')}}" alt="NoPic">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text">{{ $product->description }}</p>
                            <p class="card-text"><span class="card-attribute">Price:</span>  ${{ $product->price }}</p>
                            @if($product->quantity == 0)
                            <p class="out-of-stock">Out Of Stock!</p>
                            @else
                            <p class="card-text"><span class="card-attribute">Quantity:</span> {{ $product->quantity }}</p>
                            @endif
                            <a href="{{route('product.show',$product->id)}}">
                                <input type="submit" value="Show" class="card-button show-product">
                            </a>
                            <a href="#">
                                <input type="submit" value="Add To Cart" class="card-button add-to-cart" @if($product->quantity == 0) disabled @endif>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @endif
    </div>
    @include('layouts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
