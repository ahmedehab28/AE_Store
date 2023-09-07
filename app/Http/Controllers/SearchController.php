<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $category = $request->input('category');
        $query = $request->input('query');

        if ($category == 'all') {
            $products = Product::where('name', 'like', "%$query%")
                               ->orWhere('description', 'like', "%$query%")
                               ->get();
        } else {
            $products = Product::where('category_id', $category)
                               ->where(function ($q) use ($query) {
                                   $q->where('name', 'like', "%$query%")
                                     ->orWhere('description', 'like', "%$query%");
                               })
                               ->get();
        }

        return view('search', compact('products'));
    }
}
