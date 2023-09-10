<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="{{ asset('css/products/product-card.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('js/reload.js') }}"></script>

    <title>Home</title>
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

        <div class="jumbotron text-center">
            <h1 class="display-4">Welcome to AE Store!</h1>
            <p class="lead">Find the best products at the best prices.</p>
            <p>Start shopping now and explore our wide range of products.</p>

            <hr class="my-4">
        </div>

        @if (!$products->isEmpty())
            <div class="container-fluid my-container">
                <h2>Our Latest Products</h2>

                <div class="d-flex flex-row flex-nowrap">
                    <button class="btn btn-secondary me-3" id="scroll-left">←</button>
                    <div class="d-flex flex-row flex-nowrap overflow-auto align-items-stretch">
                        @foreach ($products as $product)
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                <div class="card mx-2" style="width: 18rem;">
                                    @if ($product->picture && file_exists(public_path('images/products/' . $product->picture)))
                                        <img src="{{ asset('images/products/' . $product->picture) }}"
                                            class="card-img-top img-fluid" alt="{{ $product->name }}"
                                            style="width: 100%; height: 100%;">
                                    @else
                                        <img src="{{ asset('images/header-logo.png') }}" class="card-img-top img-fluid"
                                            alt="NoPic" style="width: 100%; height: 100%;">
                                    @endif

                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                        <h6 class="card-subtitle">{{ $product->category->name }}</h6>

                                        <p class="card-text card-description">{{ $product->description }}</p>
                                        <p class="card-text"><span class="card-attribute">Price:</span>
                                            ${{ $product->price }}</p>
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
                                                    <input type="submit" value="Add To Cart"
                                                        class="card-button add-to-cart"
                                                        @if ($product->quantity == 0) disabled @endif>
                                                    <input type="number" class="form-control" name="quantity"
                                                        id="quantity" placeholder="quantity" value="1" min="1"
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
                                                        <input type="submit" value="Delete"
                                                            class="card-button delete-product">
                                                    </a>
                                                </form>
                                            </div>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button class="btn btn-secondary ms-3" id="scroll-right">→</button>
                </div>
            </div>
        @endif



    </div>
    @include('layouts.footer')
    <script src="{{ asset('js/home.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
