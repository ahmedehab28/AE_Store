<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link href="{{ asset('css/products/product-card.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ asset('css/products/show.css') }}" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="{{asset('css/index.css')}}">


    <title>{{ $product->name }}</title>
</head>

<body>
    @include('layouts.header')
    <div class="main-body-container">
        <div class="card">
            @if ($product->picture)
                <img src="{{ asset('images/' . $product->picture) }}" class="card-img-top" alt="{{ $product->name }}">
            @else
                <img src="{{ asset('images/header-logo.png') }}" alt="NoPic">
            @endif
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <h6 class="card-title">{{ $product->category->name }}</h6>
                <p class="card-text">{{ $product->description }}</p>
                <p class="card-text"><span class="card-attribute">Price:</span> ${{ $product->price }}</p>
                @if ($product->quantity == 0)
                    <p class="out-of-stock">Out Of Stock!</p>
                @else
                    <p class="card-text"><span class="card-attribute">Quantity:</span> {{ $product->quantity }}</p>
                @endif

                @cannot('manage')
                <form action="{{ route('product.buy', $product) }}" method="POST">
                    @csrf
                    @if (!$product->quantity == 0)
                        <input type="number" name="quantity" value="0" min="0" max="{{ $product->quantity }}">
                    @endif
                    <input type="submit" value="Buy" class="card-button show-product"
                        @if ($product->quantity == 0) disabled @endif>
                </form>
                <a href="#">
                    <input type="submit" value="Add To Cart" class="card-button add-to-cart"
                        @if ($product->quantity == 0) disabled @endif>
                </a>
                @endcannot

                @can('manage')
                    <div class="card-footer row d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
                        <a href="{{ route('product.edit', $product->id) }}">
                            <input type="submit" value="Edit" class="card-button edit-product">
                        </a>
                        <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this product?')">
                            @csrf
                            @method('DELETE')
                            <a>
                                <input type="submit" value="Delete" class="card-button delete-product">
                            </a>
                        </form>
                    </div>
                @endcan
            </div>
        </div>
    </div>


    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <span class="warning-response" role="alert">
                <strong>{{ $error }}</strong>
            </span>
        @endforeach
    @endif

    @include('layouts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
