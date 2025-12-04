<?php

namespace App\Http\Controllers;

use App\Models\cr;
use Illuminate\Http\Request;
    use App\Models\Product;
    use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
         $categories  = Category::all();
        return view('categories.index', compact('categories'));
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $categories  = Category::create([
            'name' => $request->name,
        ]);

        return response()->json($categories);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, cr $cr)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $categories  = Category::findOrFail($id);
        $categories ->update([
            'name' => $request->name,
        ]);

        return response()->json($categories );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
{
    $category = Category::findOrFail($id);
    $category->delete();

    return response()->json(['success' => true]);
}

}
