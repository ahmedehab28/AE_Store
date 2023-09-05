<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    //
    function index () {
        $products = Product::get();
        return response()->json(['data'=>$products]);
    }

    function show ($id) {
        $product = Product::find($id);
        if ($product) {
            return response()->json(['data'=>$product]);
        }
        return response()->json(['message'=>'Product Not Found']);
    }

    function store (Request $request) {
        $request->validate([
            'name' => 'required|string',
            'price' => 'required|float',
            'availability'=>'required',
            'category_id' => 'required|exists:categories,id'
        ]);

        try {
            $product = Product::create($request->all());
            return response()->json(['data'=>$product]);
        } catch (\Throwable $th) {
            return response()->json(['message'=>'Server is down']);
        }
    }

    function edit ($id, Request $request) {
        $request->validate([
            'name' => 'string',
            'price' => 'numeric',
            'category_id' => 'exists:categories,id'
        ]);
        $product = Product::find($id);
        if ($product) {
            $product->update($request->all());
            return response()->json(['data'=>$product,'message'=>'Updated Succesfully']);
        }
        return response()->json(['message'=>'Product Not Found']);
    }

    function destroy ($id) {
        $product = Product::find($id);
        if ($product) {
            $product->delete();
            return response()->json(['message'=>'Deleted Succesfully']);
        }
        return response()->json(['message'=>'Product Not Found']);
    }
}
