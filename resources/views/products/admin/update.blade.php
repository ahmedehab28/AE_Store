<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('css/products/create.css') }}">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">

    <script src="{{ asset('js/reload.js') }}"></script>

    <title>Edit Product {{ $product->id }}</title>
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
        <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data"
            class="create-product">
            <h1>Edit product!</h1>
            @method('PUT')
            @csrf
            {{-- PATCH to update in parts of data , PUT to update in all of the data --}}
            <div class="form-group">
                <label for="name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" value="{{ $product->name }}">
                </div>
            </div>

            <div class="form-group">
                <label for="description" class="col-sm-2 control-label">Description</label>
                <div class="col-sm-10">
                    <textarea class="form-control" name="description" rows="4" cols="50" value="{{ $product->description }}">{{ $product->description }}</textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="price" class="col-sm-2 control-label">Price</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="price" value="{{ $product->price }}">
                </div>
            </div>

            <div class="form-group">
                <label for="quantity" class="col-sm-2 control-label">Quantity</label>
                <div class="col-sm-10">
                    <input type="number" class="form-control" name="quantity" value="{{ $product->quantity }}">
                </div>
            </div>

            <div class="form-group">
                <label for="category_id" class="col-sm-2 control-label">Category</label>
                <div class="col-sm-10">
                    <select class="form-control" name="category_id" id="category_id">
                        <option value="{{ $product->category->id }}">{{ $product->category->name }}</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="picture" class="col-sm-2 control-label">Picture</label>
                <div class="col-sm-10">
                    <input type="file" name="picture" id="picture">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" class="btn btn-primary">
                </div>
            </div>
        </form>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
</body>

</html>
