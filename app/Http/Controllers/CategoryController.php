<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use Mpdf\Mpdf;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
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

        $category = Category::create([
            'name' => $request->name,
        ]);

        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return response()->json($category);
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


public function exportPdf()
{
    $categories = Category::all();
    $html = view('categories.pdf', compact('categories'))->render();

    $mpdf = new Mpdf([
        'default_font' => 'dejavusans',
        'format' => 'A4',
        'margin_top' => 10,
        'margin_bottom' => 10,
    ]);

    $mpdf->SetCompression(true);

    $mpdf->useSubstitutions = false;
    $mpdf->simpleTables = true;
    $mpdf->packTableData = true;
    $mpdf->WriteHTML($html);

    return response($mpdf->Output('', 'S'), 200)
        ->header('Content-Type', 'application/pdf')
        ->header('Content-Disposition', 'attachment; filename="categories.pdf"');
}

}
