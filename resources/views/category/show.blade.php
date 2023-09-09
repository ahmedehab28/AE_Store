<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/create.css') }}">
    <script src="{{ asset('js/reload.js') }}"></script>

    <title>{{ $category->name }} Category</title>
</head>

<body>
    @include('layouts.header')
    <div class="main-body-container">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <h1>{{ $category->name }}</h1>
        <div class="container">
            <div class="row">
                @foreach ($category->products as $product)
                    <div class="col-12 my-2">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <h5 class="card-title">{{ $product->name }}</h5>
                                    </div>
                                    <div>
                                        <a href="{{ route('product.show', $product->id) }}"
                                            class="btn btn-primary">Show</a>
                                        @can('manage')
                                            <a href="{{ route('product.edit', $product->id) }}"
                                                class="btn btn-secondary">Edit</a>
                                            <form action="{{ route('product.destroy', $product->id) }}" method="POST"
                                                style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        @endcan
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
    @include('layouts.footer')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

</body>

</html>
