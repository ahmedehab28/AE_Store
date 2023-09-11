<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/products/product-card.css') }}">
    <link rel="stylesheet" href="{{ asset('css/search.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

    <title>Search Results</title>
</head>

<body>
    @include('layouts.header')
    <div class="main-body-container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if (session('errors'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('errors')->first('out_of_stock') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        @if ($products->isEmpty())
            <h1>No products Found!</h1>
        @else
            <h1>Search Result</h1>
            <div class="row">
                @foreach ($products as $product)
                    <div class="col-lg-3 col-md-6 col-sm-6 d-flex">
                        <div class="card w-100 my-2 shadow-2-strong">
                            @if ($product->picture && file_exists(public_path('images/products/' . $product->picture)))
                                <img src="{{ asset('images/products/' . $product->picture) }}"
                                    class="card-img-top img-fluid" alt="{{ $product->name }}">
                            @else
                                <img src="{{ asset('images/header-logo.png') }}" class="card-img-top img-fluid"
                                    alt="NoPic">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <h6 class="card-subtitle">{{ $product->category->name }}</h6>

                                <p class="card-text card-description">{{ $product->description }}</p>
                                <p class="card-text"><span class="card-attribute">Price:</span> ${{ $product->price }}
                                </p>
                                @if ($product->quantity == 0)
                                    <p class="out-of-stock">Out Of Stock!</p>
                                @else
                                    <p class="card-text"><span class="card-attribute">Quantity:</span>
                                        {{ $product->quantity }}</p>
                                @endif
                                <div class="card-footer row d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
                                    <a href="{{ route('product.show', $product->id) }}">
                                        <input type="submit" value="Show" class="card-button show-product">
                                    </a>
                                    @cannot('manage')
                                        <form action="{{ route('cart.add', $product) }}" method="POST">
                                            @csrf
                                            <input type="submit" value="Add To Cart" class="card-button add-to-cart"
                                                @if ($product->quantity == 0) disabled @endif>
                                            <input type="number" class="form-control" name="quantity" id="quantity"
                                                placeholder="quantity" value="1" min="1"
                                                max="{{ $product->quantity }}"
                                                @if ($product->quantity == 0) disabled @endif>
                                        </form>
                                    @endcannot
                                </div>
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
                @endforeach
            </div>
        @endif
    </div>

    @include('layouts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
