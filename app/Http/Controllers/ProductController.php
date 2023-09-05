<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;


class ProductController extends Controller
{
    function index() {
        $products = Product::get();

        // dd($products->count());
        // dd($products->first());
        // dd($products->last());
        // dd($products->toArray());
        // dd($products->where('name','shai_'));
        return view('products.index',['products'=>$products]);
    }

    function show($id) {
        // $product2 = Product::where('price','>',10)->get();
        $product = Product::findOrFail($id);
        return view('products.show', compact('product'));
    }


    function destroy($id) {
        $product = Product::findOrFail($id);
        if ($product->picture){
            unlink(public_path('images/' . $product->picture));
        }
        Product::findOrFail($id)->delete();
        return redirect()->route('product.index');
    }

    function update($id) {
        $product = Product::findOrFail($id);
        return view('products.update', compact('product'));
    }

    function edit($id, Request $request) {
        $product = Product::findOrFail($id);

        if ($request->hasFile('picture')) {
            if ($product->picture){
                unlink(public_path('images/' . $product->picture));
            }
            $image = $request->file('picture');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
        } else {
            $imageName = $product->picture;
        }

        $product->update([
            "name"=>$request->name,
            "picture"=>$imageName,
            "availability"=>$request->availability,
            "price"=>$request->price,
            "category_id"=>$request->category_id,
            // "admin_id"=>$request->admin_id
        ]);

        return redirect()->route('product.index');
    }

    function create () {
        return view('products.create');
    }

    function store(Request $request) {
        $imageName = null;
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
        }

        Product::create([
            "name"=>$request->name,
            "picture"=>$imageName,
            "availability"=>$request->availability,
            "price"=>$request->price,
            "category_id"=>$request->category_id,
            // "admin_id"=>$request->admin_id
        ]);
        return redirect()->route('product.index');
    }
}
