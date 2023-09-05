<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        input {
            display: block;
        }
    </style>
    <title>Update Form</title>
</head>
<body>
    <form action="{{route('product.edit', $product->id)}}" method="post" enctype="multipart/form-data">
        @method('PUT')
        @csrf
        {{-- PATCH to update in parts of data , PUT to update in all of the data --}}
        <input type="text" name="name" value="{{$product->name}}">
        <input type="text" name="price" value="{{$product->price}}">
        <input type="text" name="availability" value="{{$product->availability}}">
        <input type="text" name="category_id" value="{{$product->category_id}}">
        <input type="text" name="admin_id" value="{{$product->admin_id}}">
        <input type="file" name="picture">
        <input type="submit" name="" >
    </form>
</body>
</html>
