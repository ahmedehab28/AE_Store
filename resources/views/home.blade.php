<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link href="{{ asset('css/products/product-card.css') }}" rel="stylesheet" type="text/css">
    <script src="{{ asset('js/reload.js') }}"></script>

    <title>Home</title>
</head>

<body>
    @include('layouts.header')
    <div class="home-body">
        <h1>HOME SWEET HOME</h1>


        <div class="container-fluid my-container">
            <h2>Our Latest Products</h2>

            <div class="d-flex flex-row flex-nowrap">
                <button class="btn btn-secondary me-3" id="scroll-left">←</button>
                <div class="d-flex flex-row flex-nowrap overflow-auto align-items-stretch">
                    @foreach ($products as $product)
                        <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                            <div class="card mx-2">
                                @if ($product->picture)
                                    <img src="{{ asset('images/' . $product->picture) }}" class="card-img-top img-fluid"
                                        alt="{{ $product->name }}">
                                @else
                                    <img src="{{ asset('images/header-logo.png') }}" class="card-img-top img-fluid"
                                        alt="NoPic">
                                @endif
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">{{ $product->name }}</h5>
                                    <p class="card-text">{{ $product->description }}</p>
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
                                            <a href="#">
                                                <input type="submit" value="Add To Cart" class="card-button add-to-cart"
                                                    @if ($product->quantity == 0) disabled @endif>
                                            </a>
                                        @endcannot
                                    </div>
                                    @can('manage')
                                        <div class="card-footer row d-flex align-items-end pt-3 px-0 pb-0 mt-auto">
                                            <a href="{{ route('product.update', $product->id) }}">
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
                <button class="btn btn-secondary ms-3" id="scroll-right">→</button>
            </div>
        </div>



    </div>
    @include('layouts.footer')
    <script src="{{ asset('js/home.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
