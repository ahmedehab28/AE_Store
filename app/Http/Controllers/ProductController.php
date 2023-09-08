<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

use Illuminate\Validation\Rule;

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


    public function destroy($id) {
        try {
            $product = Product::findOrFail($id);
            if ($product->picture){
                unlink(public_path('images/' . $product->picture));
            }
            $product->delete();
            return redirect()->route('product.index')->with('success', 'Product deleted successfully!');
        } catch (\Exception $e) {
            return redirect()->route('product.index')->with('error', 'An error occurred while deleting the product. Please try again.');
        }
    }


    function edit($id) {
        $product = Product::findOrFail($id);
        $categories = Category::all();

        return view('products.admin.update', ["product"=>$product,"categories"=>$categories]);
    }

    public function update($id, Request $request) {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description'=> 'required|max:255',
            'picture' => 'nullable|image',
            'quantity' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('product.edit', $id)
                        ->withErrors($validator)
                        ->withInput();
        }

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

        // Sanitization
        $name = strip_tags($request->name);
        $description = strip_tags($request->description);   // using strip_tag to allow the ' char
        $quantity = filter_var($request->quantity, FILTER_SANITIZE_NUMBER_INT);
        $price = filter_var($request->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $category_id = filter_var($request->category_id, FILTER_VALIDATE_INT);


        // Check if data has changed
        if ($name == $product->name &&
            $description == $product->description &&
            $imageName == $product->picture &&
            $quantity == $product->quantity &&
            $price == $product->price &&
            $category_id == $product->category_id) {
                return redirect()->route('product.index')->with('success', 'No changes were made to the product.');
        }

        DB::beginTransaction();
        try {
            $product->update([
                "name" => $name,
                "description" => $description,
                "picture" => $imageName,
                "quantity" => $quantity,
                "price" => $price,
                "category_id" => $category_id,
            ]);
            DB::commit();
            return redirect()->route('product.index')->with('success', 'Product updated successfully!');
        } catch (\Exception $e) {
            // Error handling
            DB::rollBack();
            if ($imageName && $imageName != $product->picture) {
                File::delete(public_path('images/' . $imageName));
            }
            return back()->with('error', 'There was a problem updating the product: ' . $e->getMessage());
        }
    }


    function create () {
        $categories = Category::all();
        return view('products.admin.create', compact('categories'));
    }

    public function store(Request $request) {
        // Validation
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'description'=> 'required|max:255',
            'picture' => 'nullable|image',
            'quantity' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:1',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return redirect()->route('product.create')
                        ->withErrors($validator)
                        ->withInput();
        }

        $imageName = null;
        if ($request->hasFile('picture')) {
            $image = $request->file('picture');
            $imageName = time() . '.' . $image->extension();
            $image->move(public_path('images'), $imageName);
        }

        // Sanitization
        $name = filter_var($request->name, FILTER_SANITIZE_STRING);
        $description = filter_var($request->description, FILTER_SANITIZE_STRING);
        $quantity = filter_var($request->quantity, FILTER_SANITIZE_NUMBER_INT);
        $price = filter_var($request->price, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $category_id = filter_var($request->category_id, FILTER_VALIDATE_INT);

        DB::beginTransaction();
        try {
            Product::create([
                "name" => $name,
                "description" => $description,
                "picture" => $imageName,
                "quantity" => $quantity,
                "price" => $price,
                "category_id" => $category_id,
            ]);
            DB::commit();
            return redirect()->route('product.index')->with('success', 'Product Created successfully!');
        } catch (\Exception $e) {
            // Error handling
            DB::rollBack();
            if ($imageName) {
                File::delete(public_path('images/' . $imageName));
            }
            return back()->with('error', 'There was a problem creating the product: ' . $e->getMessage());
        }
    }


}
