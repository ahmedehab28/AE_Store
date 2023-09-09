<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = Category::orderBy('name')->get();
        return view('category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return redirect()->route('category.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        // Validation
        $request->validate([
            'name' => 'required|unique:categories|max:255',
        ]);

        // Sanitization
        $name = filter_var($request->name, FILTER_SANITIZE_STRING);

        // Create category
        DB::beginTransaction();
        try {
            Category::create([
                'name' => $name,
            ]);
            DB::commit();
            return redirect()->route('category.index')->with('success', 'Category created successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'There was a problem creating the category: ' . $e->getMessage());
        }
    }


    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        //
        $category = Category::findOrFail($id);
        return view('category.show', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {
        try {
            $category = Category::findOrFail($id);

            // Validation
            $validatedData = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name,' . $id
            ]);

            if ($category->name == $validatedData['name']) {
                return redirect()->back()->with('error', 'Category is already named like that');
            }
            // Update the category name
            $category->name = $validatedData['name'];
            $category->save();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Category updated successfully!');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Category not found!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->validator->messages())->withInput();
        }


    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
