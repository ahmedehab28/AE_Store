<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">

    <title>Home</title>
</head>

<body>
    @include('layouts.header')
    <div class="home-body">
        <h1>HOME SWEET HOME</h1>
        <div id="productCarousel" class="latest-product-container carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                @foreach ($products as $index => $product)
                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                        @if($product->image)
                        <img src="{{ $product->image }}" class="d-block  latest-product-image" alt="{{ $product->name }}">
                        @else
                        <img src="{{ asset('images/header-logo.png') }}" class="d-block latest-product-image" alt="{{ $product->name }}">
                        @endif
                        <div class="carousel-caption d-none d-md-block">
                            <h5>{{ $product->name }}</h5>
                            <p>{{ $product->description }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>


    </div>
    @include('layouts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
